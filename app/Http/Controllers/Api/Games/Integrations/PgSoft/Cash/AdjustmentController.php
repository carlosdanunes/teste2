<?php

namespace App\Http\Controllers\Api\Games\Integrations\PgSoft\Cash;

use App\Http\Controllers\Controller;
use App\Http\Requests\Integrations\PgSoft\Cash\AdjustmentRequest;
use App\Models\GamesBet;
use App\Models\PgLog;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

class AdjustmentController extends Controller
{
    public function __invoke(AdjustmentRequest $request)
    {
        PgLog::create([
            'name' => 'TransferInOutRequest',
            'request' => $request->all(),
        ]);

        $validated = $request->validated();
        $transfer_amount = (int) number_format(((float) $request->get('transfer_amount')) * 100, 0, '', '');

        $user = User::query()
            ->where('ref_code', $validated['player_name'])
            ->first();

        if (empty($user)) {
            return response()->json([
                'data' => null,
                'error' => [
                    'code' => '3004',
                    'message' => 'Player does not exist',
                ],
            ]);
        }

        if($validated['currency_code'] < 0) {
            return response()->json([
                'data' => null,
                'error' => [
                    'code' => '1034',
                    'message' => 'Invalid request',
                ],
            ]);
        }

        //Verifica o tipo do ajuste, nao permite ajuste de torneios e freegame
        if($validated['transaction_type'] != '900' || empty($user->wallet)){
            return response()->json([
                'data' => null,
                'error' => [
                    'code' => '3005',
                    'message' => 'Player wallet does not exist',
                ],
            ]);
        }

        if(($user->wallet->balance + $transfer_amount) < 0) {
            return response()->json([
                'data' => null,
                'error' => [
                    'code' => '3202',
                    'message' => 'Insufficient balance',
                ],
            ]);
        }

        GamesBet::query()->firstOrCreate(
            [
                'user_id' => $user->id,
                'parent_bet_id' => $validated['adjustment_transaction_id'],
                'bet_id' => $validated['adjustment_transaction_id'],
                'game_id' => null,
            ],
            [
                'bet' => $transfer_amount,
                'balance_type' => 'wallet',
                'win' => true,
                'payout_multiplier' => 1,
            ]
        );

        $balance = Wallet::where('user_id', $user->id)->where('type', 'main')->first()->balance;

        return response()->json([
            'data' => [
                'adjust_amount' => $validated['transfer_amount'],
                'balance_before' => number_format(($balance - $transfer_amount)/100, 2, '.', ''), //diminuir o valor after do saldo
                'balance_after' => number_format($balance/100, 2, '.', ''),
                'updated_time' => round(microtime(true) * 1000),
            ],
            'error' => null,
        ]);
    }
}
