<?php

namespace App\Services\Response;

use ArrayObject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ResponseManager
{
    public function success(array $data = [], array $metadata = [], int $code = Response::HTTP_OK, int $httpCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'data' => empty($data) ? new ArrayObject() : array_merge($data, [
                'metadata' => empty($metadata) ? new ArrayObject() : $metadata,
            ]),
        ], $httpCode);
    }

    public function failure(
        string $message = 'errors.system_error',
        array $optional = [],
        int $status = 500,
        int $httpCode = 500
    ): JsonResponse {
        return response()->json(array_merge([
            'code' => $status,
            'message' => $message,
        ], $optional), $httpCode);
    }
}
