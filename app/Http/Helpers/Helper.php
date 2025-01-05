<?php

if (!function_exists('apiResponse')) {
    function apiResponse($error, array $messages, mixed $data = [], $code = 200) {
        return response()->json([
            'error' => $error,
            'messages' => $messages,
            'results' => $data,
        ], $code);
    }
}
