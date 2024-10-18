<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\JavaAuthService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;
use Mockery;

class AuthIntegrationTest extends TestCase
{
    public function test_register_success()
    {
        // Mock del cliente Guzzle
        $mockClient = Mockery::mock(Client::class);
        $mockClient->shouldReceive('post')
            ->with('/auth/register', [
                'json' => [
                    'name' => 'John Doe',
                    'email' => 'johndoe@example.com',
                    'password' => 'password123'
                ]
            ])
            ->andReturn(new Response(201));

        // Instancia del servicio con el cliente mockeado
        $service = new JavaAuthService($mockClient);

        // Datos de registro
        $data = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123'
        ];

        // Llamada al método register
        $statusCode = $service->register($data);

        // Afirmación del código de estado
        $this->assertEquals(201, $statusCode);
    }

    public function test_login_success()
    {
        // Mock del cliente Guzzle
        $mockClient = Mockery::mock(Client::class);
        $mockClient->shouldReceive('post')
            ->with('/auth/login', [
                'json' => [
                    'email' => 'johndoe@example.com',
                    'password' => 'password123'
                ]
            ])
            ->andReturn(new Response(200, [], json_encode(['token' => 'dummy-token'])));

        // Instancia del servicio con el cliente mockeado
        $service = new JavaAuthService($mockClient);

        // Credenciales de login
        $credentials = [
            'email' => 'johndoe@example.com',
            'password' => 'password123'
        ];

        // Llamada al método login
        $response = $service->login($credentials);

        // Afirmaciones de la respuesta y del código de estado
        $this->assertEquals(200, $response['code']);
        $this->assertArrayHasKey('token', $response['response']);
        $this->assertEquals('dummy-token', $response['response']['token']);
    }

    public function test_login_failure()
    {
        // Mock del cliente Guzzle para una respuesta de error
        $mockClient = Mockery::mock(Client::class);
        $mockClient->shouldReceive('post')
            ->with('/auth/login', [
                'json' => [
                    'email' => 'johndoe@example.com',
                    'password' => 'wrongpassword'
                ]
            ])
            ->andThrow(new RequestException('Unauthorized', new \GuzzleHttp\Psr7\Request('POST', '/auth/login')));

        // Instancia del servicio con el cliente mockeado
        $service = new JavaAuthService($mockClient);

        // Credenciales de login incorrectas
        $credentials = [
            'email' => 'johndoe@example.com',
            'password' => 'wrongpassword'
        ];

        // Llamada al método login
        $response = $service->login($credentials);

        // Afirmación de que la respuesta es null debido a un error
        $this->assertNull($response);
    }
}
