<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success($data = null, string $message = 'Success', $key = 'data', int $status = 200): JsonResponse
    {
        $response = ['message' => $message];

        if (! is_null($data)) {
            $response[$key] = $data;
        }

        return response()->json($response, $status);
    }

    public static function error(string $message = 'Error', int $status = 500, $errors = null): JsonResponse
    {
        $response = ['message' => $message];

        if (! is_null($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }
}
