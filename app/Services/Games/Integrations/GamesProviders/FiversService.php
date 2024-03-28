<?php

namespace App\Services\Games\Integrations\GamesProviders;

use GuzzleHttp\Client;
use http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FiversService
{

    protected string $webhook_debug_url = "https://webhook.site/657a403e-61ac-4199-8e44-3bf8d0ce2933";

    protected string $baseUrl;
    protected string $agent_code;
    protected string $agent_token;

    protected string $baseUrl_demo;
    protected string $agent_token_demo;

    public function __construct(){

        $this->baseUrl = "https://api.fiverscan.com";
        $this->agent_code = "zinbets";
        $this->agent_token = "728bf5b3b18845021d06fb4fff8e326c";

        $this->baseUrl_demo = "https://api.fivervision.com"; // 5 accounts
        $this->agent_token_demo = "5bd960c3609ad11c358ef631222ab897";
    }

    public function sendRequest($method, $type, $data)
    {
        $client = new Client();

        $requestData = is_array($data) ? $data : [];

        // For fake users, change token with infinity balance;
        if($type == 'demo'){
            $this->baseUrl = $this->agent_token_demo;
            $this->agent_token = $this->agent_token_demo;
        }

        $formData = [
            'method' => $method,
            'agent_code' => $this->agent_code,
            'agent_token' => $this->agent_token,
            ...$requestData
        ];

        $promise = $client->postAsync($this->baseUrl, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
            'json' => $formData
        ]);

        // Debug request
        //$this->debug($formData);
        
        try {
            $response = $promise->wait();

            // warn!
            if($response->getStatusCode() == 200) return $response->getBody()->getContents();
            
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        
    }

    /*private function debug($data){
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

        if($error) resonse()->json($error);
        else resonse()->json($response);
    }*/
    
}