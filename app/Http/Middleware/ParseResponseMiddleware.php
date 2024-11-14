<?php

namespace App\Http\Middleware;

use App\Helpers\GlobalHelpers;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ParseResponseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var JsonResponse|\Illuminate\Http\Response */
        $response = $next($request);

        if (method_exists($response, 'getData') && $response?->getData()) {
            $responseArray = json_decode(json_encode($response->getData()), true);
            $responseData  = GlobalHelpers::recursiveChangeCaseKeys($responseArray, 'camel');
            $response->setData($responseData);
        }
        return $response;
    }
}
