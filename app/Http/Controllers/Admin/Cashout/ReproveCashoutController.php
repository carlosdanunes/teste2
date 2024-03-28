<?php

namespace App\Http\Controllers\Admin\Cashout;

use App\Enum\TransactionStatus;
use App\Http\Controllers\Controller;
use App\Models\Payment\Cashout;
use Illuminate\Http\Request;

class ReproveCashoutController extends Controller
{
    public function __invoke(Cashout $cashout)
    {
        if ($cashout->status !== TransactionStatus::Pending->value) {
            return response()->json(['message' => 'Não foi possível reprovar o saque, pois o mesmo não está pendente'], 400);
        }

        $cashout->update([
            'approved_by' => auth()->user()->id,
            'status' => TransactionStatus::Refused->value
        ]);

        return response()->json(['message' => 'Saque reprovado com sucesso!'], 200);
    }
}
