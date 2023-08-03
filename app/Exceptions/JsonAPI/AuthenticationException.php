<?php

namespace App\Exceptions\JsonAPI;

use Exception;
use Illuminate\Http\JsonResponse;

class AuthenticationException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json([
            'errors' => [
                [
                    'title' => 'Unauthenticated',
                    'detail' => 'You are not authenticated,check your credentials and try again.',
                ],
            ],
        ], 401);
    }
}
