<?php

namespace App\Services\Games\Integrations\GamesProviders;

use GuzzleHttp\Client;
use http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class EzzuigiService
{
    private $baseUrl;
    private $operator_token;
    private $secret_key;


    public function __construct(public string $gameId = '1')
    {
        $this->baseUrl = env('EZZUGI_BASE_URL', 'https://sboapi.ezugi.com/get/');
        $this->operator_token = env('EZZUGI_OPERATOR_TOKEN');
        $this->secret_key = env('EZZUGI_SECRET_KEY');
    }

    public function generateGameUrl(string $ops)
    {
        $body = [
            'operator_token' => $this->operator_token,
            'path' => '/' . $this->gameId . '/index.html',
            'extra_args' => http_build_query([
                'btt' => '1',
                'ot' => $this->operator_token,
                'ops' => $ops,
            ]),
            'url_type' => 'game-entry',
            'client_ip' => request()->header('x-vapor-source-ip') ?? request()->ip() ?? '127.0.0.1',
        ];

        return Http::baseUrl($this->baseUrl)
            ->withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
            ])
            ->asForm()
            ->post('/external-game-launcher/api/v1/GetLaunchURLHTML', $body);
    }

    public function getGameList()
    {
        try {
            $client = new Client();
            $headers = [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ];
            $options = [
                'form_params' => [
                    'operator_token' =>  $this->operator_token,
                    'secret_key' =>  $this->secret_key,
                    'currency' => 'BRL',
                    'status' => '1',
                ],
            ];
            $request = $client->request('POST', 'https://api.pg-bo.me/external/Game/v2/Get?trace_id=' . Str::uuid(), $headers);
            $res = $client->sendAsync($request, $options)->wait();
            return $res->getBody();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
