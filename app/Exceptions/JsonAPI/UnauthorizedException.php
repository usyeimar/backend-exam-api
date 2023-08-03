<?php

namespace App\Exceptions\JsonAPI;

use Exception;
use Illuminate\Http\JsonResponse;

class UnauthorizedException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'errors' => [
                [
                    'title' => 'Unauthorized',
                    'detail' => $this->getMessage(),
                ],
            ],
        ], 401);
    }
}
