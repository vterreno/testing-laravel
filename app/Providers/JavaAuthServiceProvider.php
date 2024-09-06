<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class JavaAuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Registrar el cliente HTTP para la API de autenticación
        $this->app->singleton('JavaAuthClient', function ($app) {
            return new Client([
                'base_uri' => env('JAVA_AUTH_ENDPOINT'), 
                'timeout'  => 10.0, 
            ]);
        });

        // Registrar el servicio de autenticación
        $this->app->singleton('JavaAuthService', function ($app) {
            return new \App\Services\JavaAuthService($app->make('JavaAuthClient'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
