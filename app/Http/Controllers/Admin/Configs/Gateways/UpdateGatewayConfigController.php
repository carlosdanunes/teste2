<?php

namespace App\Http\Controllers\Admin\Configs\Gateways;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Configs\Gateways\UpdateGatewayConfigRequest;
use App\Http\Resources\Admin\Configs\Gateways\SettingsGatewayResource;
use App\Models\SettingsGateway;

class UpdateGatewayConfigController extends Controller
{
    public function __invoke(UpdateGatewayConfigRequest $request, SettingsGateway $settingsGateway)
    {
        $request = $request->validated();

        $settingsGateway->update($request);

        return response()->json([
            'message' => 'Configuração de gateway atualizada com sucesso',
            'settingsGateway' => (new SettingsGatewayResource($settingsGateway))
        ]);
    }
}
