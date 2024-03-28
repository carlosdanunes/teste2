<?php

namespace App\Http\Controllers\Admin\Configs\Gateways;

use App\Http\Controllers\Controller;
use App\Models\SettingsGateway;

class DeleteGatewayConfigController extends Controller
{
    public function __invoke(SettingsGateway $settingsGateway)
    {
        $activesSettingsGateway = SettingsGateway::where('is_active', true)->get();

        if ($activesSettingsGateway->count() === 1 && $activesSettingsGateway->first()->gateway_id === $settingsGateway->gateway_id) {
            $gateway = $settingsGateway->gateway;
            return response()->json([
                'message' => "O gateway {$gateway->name} é o único gateway ativo, não é possível desativá-lo",
            ], 422);
        }
        $settingsGateway->delete();

        return response()->json([
            'message' => 'Configuração de gateway deletada com sucesso',
        ]);

    }
}
