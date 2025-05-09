<?php

namespace App\Http\Traits;

trait ResponseTrait
{
    protected function successResponse($data = [], $message = 'success', $code = 200)
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'payload' => $data
        ], $code);
    }
}
