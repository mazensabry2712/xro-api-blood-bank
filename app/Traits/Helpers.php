<?php

namespace App\Traits;

trait Helpers
{

    public function successResponse($data = null, $message = "Success Response")
    {
        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => $message
        ], 200);
    }

    public function errorResponse($data = null, $message = "Error Response")
    {
        return response()->json([
            'status' => false,
            'data' => $data,
            'message' => $message
        ], 401);
    }
}
