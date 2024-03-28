<?php

namespace App\Services\Payment\Gateways;

use App\Enum\TransactionStatus;
use App\Models\Gateway;
use App\Models\Payment\Cashout;
use App\Models\Payment\Deposit;
use App\Models\SettingsGateway;
use App\Models\User;
use App\Services\Payment\QrCodeService;
use Carbon\Carbon;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class SuitPayService
{
    protected PendingRequest $client;

    public function __construct(
        public Gateway   $gateway,
        public User|null $user = null
    )
    {
        $this->baseUrl = 'https://ws.suitpay.app';

        $settingsGateway = SettingsGateway::query()
            ->where('gateway_id', $this->gateway->id)
            ->first();

        $this->client = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'ci' => data_get($settingsGateway, 'credentials.client_id'),
            'cs' => data_get($settingsGateway, 'credentials.client_secret'),
        ])
            ->baseUrl($this->baseUrl)
            ->connectTimeout(3)
            ->retry(3, 100, function ($exception) {
                return $exception instanceof ConnectionException;
            })
            ->throw(function (Response $response, RequestException $e) {
                throw new \Exception($response['message']);
            })
            ->timeout(30);
    }


    public function generateQrCode(
        Deposit $deposit
    ): array|bool
    {
        $response = $this->client->post('/api/v1/gateway/request-qrcode', [
            'dueDate' => Carbon::tomorrow()->format('Y-m-d H:i:s'),
            'amount' => number_format($deposit->amount / 100, 2, '.', ''),
            'requestNumber' => $deposit->id,
            'callbackUrl' => url(env('APP_URL') . route('payment.return', ['gateway' => 'suitpay'], false)),
            'client' => [
                'name' => $this->user->name,
                "document" => preg_replace('/[^0-9]/', '', $this->user->document),
                'email' => $this->user->email,
            ],
        ]);

        $statusCode = $response->getStatusCode();
        $data = $response->json();

        return [
            'response_status' => $statusCode,
            'pix_url' => $data['paymentCode'],
            'pix_qr_code' => QrCodeService::generate(data_get($data, 'paymentCode', ''), 300),
            'external_id' => $data['idTransaction'],
        ];
    }

    public function sendPayment($cashout)
    {
        match ($cashout->pix_key_type) {
            'cpf' => $cashout->pix_key = sanitize_cpf($cashout->pix_key),
            'phone' => $cashout->pix_key = '+55' . preg_replace('/[^0-9]/', '', $cashout->pix_key),
            default => $cashout->pix_key,
        };

        match ($cashout->pix_key_type) {
            'cpf' => $cashout->pix_key_type = 'document',
            'phone' => $cashout->pix_key_type = 'phoneNumber',
            'random' => $cashout->pix_key_type = 'randomKey',
            default => $cashout->pix_key_type,
        };

        $response = $this->client->post('/api/v1/gateway/pix-payment', [
            'key' => $cashout->pix_key,
            'typeKey' => $cashout->pix_key_type,
            'value' => number_format($cashout->amount / 100, 2, '.', ''),
            'callbackUrl' => url(env('APP_URL') . route('payment.return', ['gateway' => 'suitpay'], false)),
        ])->json();

        $status = match ($response['response']) {
            'UNPAID', 'WAITING_FOR_APPROVAL', 'OK' => TransactionStatus::Pending->value,
            'PAID_OUT', 'PAYMENT_ACCEPT' => TransactionStatus::Approved->value,
            'CANCELED' => TransactionStatus::Expired->value,
            'CHARGEBACK' => TransactionStatus::Chargeback->value,
            default => TransactionStatus::Pending->value,
        };

        return [
            'external_id' => $response['idTransaction'],
            'status' => $status,
        ];
    }


    public function getTransactionStatus(string $type, string $idTransaction)
    {
        $data = [
            'typeTransaction' => $type,
            'idTransaction' => $idTransaction
        ];

        return $this->client->post('/api/v1/gateway/consult-status-transaction', $data);
    }


    public function getPaymentStatus(string $transactionId): bool|array
    {
        $response = $this->getTransactionStatus('PIX_CASHOUT', $transactionId);

        $data = $response->json();

        $status = match ($data) {
            'UNPAID', 'WAITING_FOR_APPROVAL' => TransactionStatus::Pending->value,
            'PAID_OUT', 'PAYMENT_ACCEPT' => TransactionStatus::Approved->value,
            'CANCELED' => TransactionStatus::Expired->value,
            'CHARGEBACK' => TransactionStatus::Chargeback->value,
            default => TransactionStatus::Error->value,
        };

        $cashout = Cashout::where('external_id', $transactionId)->first();

        return [
            'response_status' => $response->getStatusCode(),
            'status' => $status,
            'amount' => $cashout->amount,
        ];
    }

    public function getStatusDeposit(string $transactionId): bool|array
    {
        $response = $this->getTransactionStatus('PIX', $transactionId);
        $data = $response->json();

        $status = match ($data) {
            'UNPAID', 'WAITING_FOR_APPROVAL' => TransactionStatus::Pending->value,
            'PAID_OUT', 'PAYMENT_ACCEPT' => TransactionStatus::Approved->value,
            'CANCELED' => TransactionStatus::Expired->value,
            'CHARGEBACK' => TransactionStatus::Chargeback->value,
            default => TransactionStatus::Error->value,
        };

        $deposit = Deposit::where('external_id', $transactionId)->first();

        return [
            'response_status' => $response->getStatusCode(),
            'status' => $status,
            'amount' => $deposit->amount,
        ];
    }


    public function validateReturn(array $data)
    {
        $response = $this->getTransactionStatus($data['typeTransaction'], $data['idTransaction']);

        $status = match ($response->json()) {
            'UNPAID', 'WAITING_FOR_APPROVAL' => TransactionStatus::Pending->value,
            'PAID_OUT', 'PAYMENT_ACCEPT' => TransactionStatus::Approved->value,
            'CANCELED' => TransactionStatus::Expired->value,
            'CHARGEBACK' => TransactionStatus::Chargeback->value,
            default => TransactionStatus::Error->value,
        };

        $type = match ($data['typeTransaction']) {
            'PIX' => 'deposit',
            'PIX_CASHOUT' => 'cashout',
        };

        if ($type === 'deposit') {
            $deposit = Deposit::where('external_id', $data['idTransaction'])->first();
            $amount = $deposit->amount;
        }

        if ($type === 'cashout') {
            $cashout = Cashout::where('external_id', $data['idTransaction'])->first();
            $amount = $cashout->amount;
        }

        return [
            'response_status' => $response->getStatusCode(),
            'status' => $status,
            'external_id' => $data['idTransaction'],
            'type' => $type,
            'amount' => $amount,
        ];
    }
}
