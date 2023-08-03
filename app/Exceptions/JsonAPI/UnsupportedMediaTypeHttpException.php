<?php

namespace App\Exceptions\JsonAPI;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UnsupportedMediaTypeHttpException extends Exception
{
    /**
     * Report the exception.
     */
    public function report(): void
    {
        //
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'errors' => [
                [
                    'title' => 'Unsupported Media Type',
                    'detail' => Str::of($this->getMessage())->length() > 0 ? $this->getMessage() : 'The request must be a made with a JSON API header,Check your request and try again.',
                ],
            ],
        ], 415);
    }
}
