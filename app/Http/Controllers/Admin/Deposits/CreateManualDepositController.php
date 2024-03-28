<?php

namespace App\Http\Controllers\Admin\Deposits;

use App\Enum\TransactionStatus;
use App\Events\ApprovedDepositEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\Deposit\AddCreditRequest;
use App\Models\Gateway;
use App\Models\Payment\Deposit;
use App\Models\SettingsGateway;
use App\Models\User;
use Illuminate\Support\Str;

class CreateManualDepositController extends Controller
{
    public function __invoke(AddCreditRequest $request)
    {
        $validated = $request->validated();
        $gateway = Gateway::where('slug', 'manual')->first();
        $user = User::with('wallet')->where('id', $validated['user_id'])->first();

        if (!$gateway) {
            return response()->json(['message' => 'Não foi possível encontrar o gateway manual'], 400);
        }

        $deposit = Deposit::create([
            'hash' => Str::uuid(),
            'status' => TransactionStatus::Approved->value,
            'amount' => $validated['amount'],
            'currency' => 'brl',
            'has_bonus' => $validated['has_bonus'],
            'wallet_id' => $user->wallet->id,
            'user_id' => $validated['user_id'],
            'gateway_id' => $gateway->id,
            'created_by' => auth()->user()->id,
        ]);

        if (!$deposit) {
            return response()->json(['message' => 'Não foi possível criar o deposito.'], 400);
        }

        ApprovedDepositEvent::dispatch($deposit);

        return response()->json([
            'message' => 'Deposito criado com sucesso!',
            'amount' => $deposit->amount,
        ], 201);
    }
}
