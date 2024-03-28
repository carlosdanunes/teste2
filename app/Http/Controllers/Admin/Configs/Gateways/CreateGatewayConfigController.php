<?php

namespace App\Http\Controllers\Admin\Configs\Gateways;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Configs\Gateways\CreateGatewayConfigRequest;
use App\Http\Resources\Admin\Configs\Gateways\SettingsGatewayResource;
use App\Models\Gateway;

class CreateGatewayConfigController extends Controller
{
    public function __invoke(CreateGatewayConfigRequest $request)
    {
        $request = $request->validated();

        $gateway = Gateway::find($request['gateway_id']);

        $settingsGateway = $gateway->settings()->create([
            'credentials' => $request['credentials'],
            'is_active' => $request['is_active'],
        ]);

        return response()->json([
            'message' => 'Configuração de gateway criada com sucesso',
            'settingsGateway' => (new SettingsGatewayResource($settingsGateway))
        ]);
    }
}
