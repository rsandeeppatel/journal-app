<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller
{
    public static function errorResponse(?array $data = [], $status = 200, $headers = [], $options = 0, $json = false)
    {
        return new JsonResponse([
            'success' => false,
            ...$data,
        ], $status, $headers, $options, $json);
    }

    public static function successResponse(?array $data = [], $status = 200, $headers = [], $options = 0, $json = false)
    {
        return new JsonResponse([
            'success' => true,
            ...$data,
        ], $status, $headers, $options, $json);
    }

    public static function unauthorizedResponse()
    {
        return self::errorResponse(
            data: [
                'message' => Response::$statusTexts[Response::HTTP_UNAUTHORIZED],
            ],
            status: Response::HTTP_UNAUTHORIZED
        );
    }
}
