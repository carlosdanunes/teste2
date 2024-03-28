<?php

namespace App\Http\Controllers\Admin\Deposits;

use App\Http\Controllers\Controller;
use App\Models\Payment\Deposit;

class CancelDepositController extends Controller
{
    public function __invoke(Deposit $deposit)
    {
        if(!$deposit->canBeCanceled()) {
            return response()->json([
                'message' => 'Deposito nao pode ser cancelado',
                'deposit' => $deposit->fresh(),
            ], 422);
        }

        $deposit->update([
            'status' => 'canceled',
        ]);

        return response()->json([
            'message' => 'Deposito cancelado com sucesso',
            'deposit' => $deposit->fresh(),
        ]);

    }
}
