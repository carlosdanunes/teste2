<?php

namespace App\Http\Controllers\Api\Games\Integrations;

use App\Http\Controllers\Controller;
use App\Models\GamesList;
use App\Models\GamesProvider;
use App\Models\FiversLog;
use App\Models\User;
use App\Services\Games\Integrations\GamesProviders\FiversService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LaunchGameController extends Controller
{
    protected string $webhook_debug_url = "https://webhook.site/657a403e-61ac-4199-8e44-3bf8d0ce2933";

    public function __invoke(Request $request, $game_code)
    {
        $data = $request->all();
        
        // Search game
        $game = GamesList::where('game_code', $game_code)->with('games_providers')->first();

        if(!$game){
            return response()->json([
                'data' => [
                    'status' => false,
                    'mesage' => 'Game not found or inactive.',
                ]
            ]);
        }

        if($user = auth()->user() ){

            $user_code = $user->username;
            $provider_code = $game->games_providers->provider_code;
            $game_code = $game->game_code;
            $lang = "ptbr";

            // Register Game Popularity
            $game->opens += 1;
            $game->save();

            // Validate user type [demo, live]
            $user_type = 'live';
            if($user->is_fake) $user_type = 'demo';

            // Register Logs (similar from pg_logs)
            FiversLog::create([
                'game_id' => $game->id,
                'user_id' => $user->id,
                'token' => $user_code,
                'method' => 'game_launch',
                'amount' => $user->wallet->balance,
            ]);

            // Send to Fivers and wait game url return.
            $response = (new FiversService())->sendRequest('game_launch', $user_type, [
                    'user_code' => $user_code,
                    'provider_code' =>  $provider_code,
                    'game_code' => $game_code,
                    'lang' => 'ptbr',
                ]);

             $response = json_decode($response);

            if( $response->status == 1) {
                return response()->json([
                    'data' => [
                        'operator_player_session' => $user_code,
                        'game_url' => $response->launch_url,
                    ]
                ]);
            }
            else {
                 return response()->json([
                    'data' => [
                        'operator_player_session' => $user_code,
                        'game_url' => $response->msg,
                    ],
                    'message' => 'Falha ao gerar URL do jogo.'
                ]);
            }

        }
    }

    private function debug($data){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->webhook_debug_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                 'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ),
        ));

        $response = json_decode(curl_exec($curl));
        $error = curl_error($curl);

        curl_close($curl);

        if($error) response()->json($error);
        else response()->json($response);
    }
}
