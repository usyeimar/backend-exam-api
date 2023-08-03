<?php

namespace App\Exceptions\JsonAPI;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotFoundHttpException extends \Exception
{
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'errors' => [
                [
                    'title' => 'Not Found',
                    'detail' => $this->getMessage(),
                ],
            ],
        ], 404);
    }
}
