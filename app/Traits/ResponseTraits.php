<?php

namespace App\Traits;

trait ResponseTraits
{
    protected function success($message, $data = [], $status = 200)
    {
        return response([
            'status' => $status,
            'success' => true,
            'data' => $data,
            'message' => $message,
        ], $status);
    }

    protected function failure($message, $status = 422)
    {
        return response([
            'status' => $status,
            'success' => false,
            'message' => $message,
        ], $status);
    }
}
