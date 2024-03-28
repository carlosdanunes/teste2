<?php

namespace App\Http\Controllers\Admin\Deposits;

use App\Enum\TransactionStatus;
use App\Events\ApprovedDepositEvent;
use App\Http\Controllers\Controller;
use App\Models\Payment\Deposit;
use App\Services\Payment\GatewayService;

class ValidateDepositController extends controller
{
    public function __invoke(Deposit $deposit)
    {
        if ($deposit->status === TransactionStatus::Approved->value) {
            return response()->json(['message' => 'Pagamento já aprovado!'], 200);
        }

        $validate = (new GatewayService($deposit->gateway))->getStatusDeposit($deposit->external_id);

        if (data_get($validate, 'response_status', false) !== 200) {
            return response()->json(['message' => 'Não foi possível validar o pagamento, tente novamente!'], 400);
        }

        $deposit->update([
            'status' => $validate['status'],
            'amount' => $validate['amount'],
        ]);

        if ($deposit->status === TransactionStatus::Approved->value) {
            ApprovedDepositEvent::dispatch($deposit);
        }

        return response()->json(['message' => 'Pagamento validado com sucesso!'], 200);
    }
}
