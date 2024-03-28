<?php

namespace App\Http\Controllers\Api\Games\Integrations\Fivers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\FiversLog;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class GoldAPIController extends Controller
{
    protected string $webhook_debug_url = "https://webhook.site/8a3e155f-8283-4cb8-893f-19993c071c6e";

    public function __invoke(Request $request)
    {
        $data = $request->all();

        $user_code = $request->get('user_code') ?? NULL; // Identity of third Operator
        $search = FiversLog::where('token', $user_code)->first();
        $user = $search->user;
        $game = $search->game;

        if (!$user_code ||
            !$request->get('method') ||
            !$request->get('agent_secret') ||
            !$request->get('user_code') ||
            !$request->get('agent_code')
        ) {
            return response()->json([
                'status' => 0,
                'user_balance' => 0,
                'msg' => 'External Server Error',
            ], HttpResponse::HTTP_BAD_REQUEST);
        }

        if ($user->wallet->balance < 0) {
            return response()->json([
                'status' => 0,
                'user_balance' => 0,
                'msg' => 'INSUFFICIENT_FUNDS',
            ]);
        }

        // Validate request is from Fivers
        if ($user->is_fake) $agent_secret = 'f264245931bed4e49b529986e4d50437'; else $agent_secret = '5c9ee26c4658def28db7b9eee5a0b764';

        if ($data['agent_code'] !== 'zinbets' && $data['agent_secret'] !== $agent_secret) {
            return response()->json([
                'status' => 0,
                'msg' => 'INVALID_AGENT_CODE',
            ]);
        }

        // Get User Balance
        if ($data['method'] == 'user_balance') {
            // Register log
            $search->create([
                'game_id' => $game->id,
                'user_id' => $user->id,
                'token' => $user_code,
                'method' => 'get_user_balance',
                'amount' => $user->wallet->balance
            ]);

            return response()->json([
                'status' => 1,
                'user_balance' => floatval($user->wallet->balance / 100),
            ], HttpResponse::HTTP_OK);
        }


        if ($data['method'] == 'transaction') {

            if ($data['game_type'] == 'live') {

                $toCents = floatval($data['live']['bet_money'] * 100);

                // Only BET, not win
                if ($data['live']['win_money'] == 0) {
                    $user->wallet->update([
                        'balance' => $user->wallet->balance - $toCents
                    ]);

                    $this->createTransaction($user, -$toCents);

                    // Register log
                    $search->create([
                        'game_id' => $game->id,
                        'user_id' => $user->id,
                        'token' => $user_code,
                        'method' => 'bet_transaction',
                        'amount' => $toCents,
                    ]);
                }

                if ($data['live']['win_money'] > 0) {
                    $toCentsWin = floatval($data['live']['win_money'] * 100);

                    $user->wallet->update([
                        'balance' => $user->wallet->balance + ($toCentsWin - $toCents)
                    ]);

                    //TODO: criar transacao
                    $this->createTransaction($user, ($toCentsWin - $toCents));

                    // Register log
                    $search->create([
                        'game_id' => $game->id,
                        'user_id' => $user->id,
                        'token' => $user_code,
                        'method' => 'win_transaction',
                        'amount' => $toCentsWin,
                    ]);
                }

            } else { // Slot Games
                if ($data['slot']['win_money'] == 0) {

                    $toCents = floatval($data['slot']['bet_money'] * 100);

                    $user->wallet->update([
                        'balance' => $user->wallet->balance - $toCents
                    ]);

                    //TODO: criar transacao
                    $this->createTransaction($user, -$toCents);

                    // Register log
                    $search->create([
                        'game_id' => $game->id,
                        'user_id' => $user->id,
                        'token' => $user_code,
                        'method' => 'bet_transaction',
                        'amount' => $toCents,
                    ]);
                }

                if ($data['slot']['win_money'] > 0) {
                    $toCents = floatval($data['slot']['bet_money'] * 100);
                    $toCentsWin = floatval($data['slot']['win_money'] * 100);

                    $user->wallet->update([
                        'balance' => $user->wallet->balance + ($toCentsWin - $toCents)
                    ]);

                    //TODO: criar transacao
                    $this->createTransaction($user, ($toCentsWin - $toCents));

                    // Register log
                    $search->create([
                        'game_id' => $game->id,
                        'user_id' => $user->id,
                        'token' => $user_code,
                        'method' => 'win_transaction',
                        'amount' => $toCentsWin,
                    ]);
                }
            }


            return response()->json([
                'status' => 1,
                'user_balance' => floatval($user->balance),
            ]);

        } else {
            return response()->json([
                'status' => 0,
                'msg' => 'INVALID_METHOD',
            ]);
        }
    }


    private function createTransaction($user, $amount)
    {
        Transaction::create([
            'hash' => Str::uuid(),
            'amount' => $amount,
            'name' => 'cassino',
            'type' => $amount >= 0 ? 'credit' : 'debit',
            'status' => 'approved',
            'game_id' => rand(1, 10).rand(1, 10),
            'wallet_id' => $user->wallet->id,
            'bonus_id' => null,
            'user_id' => $user->id,
        ]);
    }

}
