<?php

namespace App\Services\Payment\Gateways;

use App\Enum\TransactionStatus;
use App\Models\Gateway;
use App\Models\Payment\Cashout;
use App\Models\Payment\Deposit;
use App\Models\SettingsGateway;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class GamePixService
{
    private string $baseUrl;
    private string $api_key;

    public function __construct(
        public Gateway $gateway,
        public User|null $user = null
    )
    {
        $settingsGateway = SettingsGateway::query()
            ->where('gateway_id', $this->gateway->id)
            ->first();

        $this->baseUrl = 'https://gamepix.gg/api/v1';
        $this->api_key = data_get($settingsGateway, 'credentials.api_key', '');
    }

    public function generateQrCode(
        Deposit $deposit
    ): bool|array
    {
        if (!$this->api_key) {
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $this->api_key,
            ])->post($this->baseUrl . '/gateway/cash-in', [
                "amount" => number_format($deposit->amount / 100, 2, '.', ''),
                "external_id" => (string)$deposit->id,
                "customer" => [
                    "name" => $this->user->name,
                    "document" => preg_replace('/[^0-9]/', '', $this->user->document),
                ],
            ]);

            $data = $response->json();

            return [
                'response_status' => $response->getStatusCode(),
                'pix_url' => $data['qr_code'],
                'pix_qr_code' => $data['base64QrCode'],
                'external_id' => $data['transaction_id'],
            ];
        } catch (\Exception $e) {
            return [
                'response_status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }


    public function getStatusDeposit(string $transactionId): bool|array
    {
        if (!$this->api_key) {
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $this->api_key,
            ])->post($this->baseUrl . '/gateway/consult-status-transaction', [
                'transaction_id' => $transactionId,
            ]);

            $data = $response->json();

            $status = match ($data['status']) {
                'pending' => TransactionStatus::Pending->value,
                'paid' => TransactionStatus::Approved->value,
                'expired' => TransactionStatus::Expired->value,
                'refunded' => TransactionStatus::Refused->value,
                'error' => TransactionStatus::Error->value,
                default => TransactionStatus::Processing->value,
            };

            return [
                'response_status' => $response->getStatusCode(),
                'status' => $status,
                'amount' => number_format(($data['paid_amount'] * 100), 0, '', ''),
                'type' => 'deposit',
            ];
        } catch (\Exception $e) {
            return [
                'response_status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
        }
    }

    public function getPaymentStatus(string $transactionId): bool|array
    {
        if (!$this->api_key) {
            return false;
        }

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $this->api_key,
            ])->post($this->baseUrl . '/gateway/consult-status-transaction', [
                'transaction_id' => $transactionId,
            ]);

            $data = $response->json();

            $status = match ($data['status']) {
                'pending' => TransactionStatus::Pending->value,
                'paid' => TransactionStatus::Approved->value,
                'expired' => TransactionStatus::Expired->value,
                'refunded' => TransactionStatus::Refused->value,
                'error' => TransactionStatus::Error->value,
                default => TransactionStatus::Processing->value,
            };

            return [
                'response_status' => $response->getStatusCode(),
                'status' => $status,
            ];

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return [
                'response_status' => $e->getCode(),
                'message' => data_get(json_decode($e->getResponse()->getBody()->getContents()), 'message'),
            ];
        }
    }

    public function sendPayment($cashout)
    {
        if (!$this->api_key) {
            return false;
        }

        match ($cashout->pix_key_type) {
            'phone' => $cashout->pix_key = '+55' . preg_replace('/[^0-9]/', '', $cashout->pix_key),
            default => $cashout->pix_key,
        };

        match ($cashout->pix_key_type) {
            'cpf' => $cashout->pix_key_type = 'document',
            default => $cashout->pix_key_type,
        };

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $this->api_key,
            ])->post($this->baseUrl . '/gateway/cash-out', [
                'amount' => number_format($cashout->amount / 100, 2, '.', ''),
                'type_key' => $cashout->pix_key_type,
                'key' => $cashout->pix_key,
                'external_id' => (string)$cashout->id,
                'customer' => [
                    'name' => $cashout?->user?->name ?? '',
                    'document' => preg_replace('/[^0-9]/', '', $cashout?->user?->document ?? ''),
                ],
            ]);


            if (!$response->ok()) {
                throw new \Exception(data_get($response->json(), 'message', ''));
            }

            $data = $response->json();

            $status = match ($data['status']) {
                'pending' => TransactionStatus::Pending->value,
                'paid' => TransactionStatus::Approved->value,
                'expired' => TransactionStatus::Expired->value,
                'refunded' => TransactionStatus::Refused->value,
                'error' => TransactionStatus::Error->value,
                default => TransactionStatus::Processing->value,
            };

            return [
                'response_status' => $response->getStatusCode(),
                'status' => $status,
                'external_id' => $data['transaction_id'],
            ];

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function validateReturn(): bool|array
    {
        $request = request()->all();

        $transactionType = data_get($request, 'type');
        $transactionId = data_get($request, 'transaction_id');

        if ($transactionType === 'pix') {
            $deposit = Deposit::where('external_id', $transactionId)->firstOrFail();

            $settingsGateway = SettingsGateway::query()
                ->where('gateway_id', $this->gateway->id)
                ->firstOrFail();

            $getStatusDeposit = (new GamePixService($this->gateway))->getStatusDeposit($transactionId);

            return [
                'response_status' => data_get($getStatusDeposit, 'response_status'),
                'status' =>  data_get($getStatusDeposit, 'status'),
                'amount' => data_get($getStatusDeposit, 'amount'),
                'type' =>  data_get($getStatusDeposit, 'type'),
                'external_id' => $transactionId,
            ];
        }

        if ($transactionType === 'pix_cashout') {
            $cashout = Cashout::where('external_id', $transactionId)->firstOrFail();

            $settingsGateway = SettingsGateway::query()
                ->where('gateway_id', $this->gateway->id)
                ->firstOrFail();

            $getStatusDeposit = (new GamePixService($this->gateway))->getStatusDeposit($transactionId);

            return [
                'response_status' => data_get($getStatusDeposit, 'response_status'),
                'status' =>  data_get($getStatusDeposit, 'status'),
                'external_id' => $transactionId,
                'type' => 'cashout',
                'amount' => $cashout->amount,
            ];
        }

        return false;
    }
}
