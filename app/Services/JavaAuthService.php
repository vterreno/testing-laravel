<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class JavaAuthService
{
    protected $client;

    public                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function register($data){
        Log::info($data);
        try {
            $response = $this->client->post('/auth/register', [
                'json' => $data,
            ]);

            return $response->getStatusCode();
        } catch (RequestException $e) {
            return 400;
        }
    }

    public function login($credentials)
    {
        try {
            $response = $this->client->post('/auth/login', [
                'json' => $credentials,
            ]);

            $data['response'] = json_decode($response->getBody()->getContents(), true);
            $data['code'] = $response->getStatusCode();
            Log::info($data);
            return $data;
        } catch (RequestException $e) {
            return null;
        }
    }
}
