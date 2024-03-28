<?php

namespace App\Http\Controllers\Admin\Configs\Gateways;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Configs\Gateways\CreateAvailableGatewayRequest;
use App\Models\Gateway;

class CreateAvailableGatewayController extends Controller
{
    public function __invoke(CreateAvailableGatewayRequest $request)
    {
        $gateway = Gateway::create($request->validated());

        return response()->json([
            'message' => 'Gateway criado com sucesso',
            'gateway' => $gateway
        ]);
    }
}
