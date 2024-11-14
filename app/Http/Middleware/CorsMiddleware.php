<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\{Response, BinaryFileResponse};

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \Illuminate\Http\Response */
        $response = $next($request);

        if ($response instanceof BinaryFileResponse) {
            return $response;
        }
        
        return $response
            ->header('Access-Control-Allow-Origin', config('cors.allowed_origins'))
            ->header('Access-Control-Allow-Methods', config('cors.allowed_methods'))
            ->header('Access-Control-Allow-Headers', config('cors.allowed_headers'));
    }
}
