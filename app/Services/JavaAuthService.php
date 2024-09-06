<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Flash;
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

    public function authenticate($credentials)
    {
        try {
            $response = $this->client->post('/auth/login', [
                'json' => $credentials,
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            return [$data, $response->getStatusCode()];
        } catch (RequestException $e) {
            return [null, 400];
        }
    }
}
