<?php

namespace App\Http\Controllers\Admin\Deposits;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Deposits\GetDepositsResource;
use App\Models\Payment\Deposit;

class GetDepositsByIdController extends Controller
{
    public function __invoke(Deposit $deposit)
    {
        return response()->json(new GetDepositsResource($deposit));
    }
}
