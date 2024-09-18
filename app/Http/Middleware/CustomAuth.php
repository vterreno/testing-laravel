<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Log;

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
        $token = session('token');
        // Log::info('token: ' . $token);
        if (!$token) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
