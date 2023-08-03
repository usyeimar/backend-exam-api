<?php

namespace App\Exceptions\JsonAPI;

use Exception;
use Illuminate\Support\Str;

class BadRequestHttpException extends Exception
{
    public function render($request): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'errors' => [
                [
                    'title' => 'Bad Request',
                    'detail' => Str::of($this->getMessage())->length() > 0 ? $this->getMessage() : 'Bad request, please check your request and try again.',
                ],
            ],
        ], 400);
    }
}
