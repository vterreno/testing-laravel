<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar si estamos en el entorno de pruebas
        if (app()->environment('testing')) {
            return $next($request);
        }

        // Obtener el token de la sesión
        $token = session('token');
        // Log::info('token: ' . $token);
        
        // Verificar si el token está presente
        if (!$token && (session('secret_word') != env('SECRET_WORD'))) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
