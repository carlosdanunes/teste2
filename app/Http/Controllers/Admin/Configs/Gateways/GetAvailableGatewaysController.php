<?php

namespace App\Http\Controllers\Admin\Configs\Gateways;

use App\Http\Controllers\Controller;
use App\Models\Gateway;

class GetAvailableGatewaysController extends Controller
{
    public function __invoke()
    {
        $gateways = Gateway::all();

        return response()->json([
            'message' => 'Gateways disponíveis',
            'gateways' => $gateways
        ]);
    }
}
