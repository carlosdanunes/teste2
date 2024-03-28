<?php

namespace App\Http\Controllers\Api\Payment;

use App\Enum\TransactionStatus;
use App\Events\ApprovedDepositEvent;
use App\Http\Controllers\Controller;
use App\Models\Gateway;
use App\Models\Payment\Cashout;
use App\Models\Payment\Deposit;
use App\Models\Transaction;
use App\Services\Payment\GatewayService;
use Illuminate\Http\Request;

class ReturnGatewayController extends Controller
{
    public function __invoke(Request $request, Gateway $gateway)
    {
        if($request->test && $request->test == true){
            return response()->json(['message' => 'URL Válida!'], 200);
        }

        $validate = (new GatewayService($gateway))->validateReturn($request->all());

        if(!$validate){
            return response()->json(['message' => 'Não foi possível validar o pagamento'], 400);
        }


        if($validate['type'] == 'deposit') {
            $deposit = Deposit::where('external_id', $validate['external_id'])->firstOrFail();

            if(!$deposit){
                return response()->json(['message' => 'Não foi possível encontrar o deposito'], 400);
            }

            if($deposit->status === TransactionStatus::Approved->value){
                return response()->json(['message' => 'Pagamento já aprovado!'], 200);
            }

            $deposit->update([
                'status' => $validate['status'],
                'amount' => $validate['amount'],
            ]);

            if($deposit->status === TransactionStatus::Approved->value) {
                ApprovedDepositEvent::dispatch($deposit);
            }
        }

        if($validate['type'] == 'cashout') {
            $cashout = Cashout::where('external_id', $validate['external_id'])->firstOrFail();

            if(!$cashout){
                return response()->json(['message' => 'Não foi possível encontrar o saque'], 400);
            }

            if($cashout->status === TransactionStatus::Approved->value){
                return response()->json(['message' => 'Pagamento já aprovado!'], 200);
            }

            $cashout->update([
                'status' => $validate['status'],
            ]);
        }

        return response()->json(['message' => 'Pagamento validado com sucesso!'], 200);
    }
}
