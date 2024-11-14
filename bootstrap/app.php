<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
if (! defined('API_V1')) {
    define('API_V1', 'api/v1');
}
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        apiPrefix: API_V1,
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(append: [
            \App\Http\Middleware\CorsMiddleware::class,
        ]);
        $middleware->alias([
            'parse.response' => \App\Http\Middleware\ParseResponseMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withBroadcasting(
        __DIR__ . '/../routes/channels.php',
        ['prefix' => API_V1, 'middleware' => ['api', 'auth:sanctum']],
    )
    ->create();
