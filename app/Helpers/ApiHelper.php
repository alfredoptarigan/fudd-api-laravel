<?php

namespace App\Helpers;

class ApiHelper
{
    public static function success($data = null, $message = null)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], 200);
    }

    public static function error($message = null, $data = null)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ], 400);
    }
}
