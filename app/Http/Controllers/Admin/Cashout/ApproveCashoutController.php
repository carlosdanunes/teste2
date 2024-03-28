<?php

namespace App\Http\Controllers\Admin\Cashout;

use App\Enum\TransactionStatus;
use App\Http\Controllers\Controller;
use App\Models\Payment\Cashout;
use App\Models\SettingsGateway;
use App\Services\Payment\GatewayService;

class ApproveCashoutController extends Controller
{
    public function __invoke(Cashout $cashout)
    {
        try {
            if (!$cashout) {
                return response()->json(['message' => 'Não foi possível encontrar o saque'], 400);
            }

            if($cashout->external_id) {
                return response()->json(['message' => 'Saque já solicitado!'], 400);
            }

            $settingsGateway = SettingsGateway::where('is_active', true)->first();

            $approveCashout = (new GatewayService($settingsGateway->gateway))->sendPayment($cashout);

            $cashout->update([
                'approved_by' => auth()->user()->id,
                'external_id' => $approveCashout['external_id'],
                'status' => $approveCashout['status'],
            ]);

            return response()->json(['message' => 'Saque aprovado com sucesso!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
