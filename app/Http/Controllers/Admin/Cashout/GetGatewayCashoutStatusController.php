<?php

namespace App\Http\Controllers\Admin\Cashout;

use App\Http\Controllers\Controller;
use App\Models\Payment\Cashout;
use App\Services\Payment\GatewayService;

class GetGatewayCashoutStatusController extends Controller
{
    public function __invoke(Cashout $cashout)
    {
        if (!$cashout->external_id || !$cashout->gateway) {
            return response()->json(['message' => 'Erro ao atualizar o status do saque'], 400);
        }

        $validate = (new GatewayService($cashout->gateway))->getPaymentStatus($cashout->external_id);

        if(!$validate){
            return response()->json(['message' => 'Não foi possível validar o status do pagamento'], 400);
        }

        if(
            data_get($validate,'response_status', false) == 200 ||
            data_get($validate,'response_status', false) == 201 ||
            data_get($validate,'response_status', false) == '200' ||
            data_get($validate,'response_status', false) == '201'
        ){

            $cashout->update([
                'status' => $validate['status'],
            ]);

            return response()->json(['message' => 'Status atualizado com sucesso!'], 200);
        }

        return response()->json([
            'message' => 'Não foi possível atualiza o status do saque, tente novamente!',
            'error' => data_get($validate, 'message')
        ], 400);

    }
}
