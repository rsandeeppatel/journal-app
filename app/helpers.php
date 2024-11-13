<?php

use App\Http\Controllers\Controller;

if (! function_exists('errorResponse')) {
    function errorResponse(?array $data = [], $status = 200, $headers = [], $options = 0, $json = false)
    {
        return Controller::errorResponse($data, $status, $headers, $options, $json);
    }

    if (! function_exists('unauthorizedResponse')) {
        function unauthorizedResponse()
        {
            return Controller::unauthorizedResponse();
        }
    }
}
