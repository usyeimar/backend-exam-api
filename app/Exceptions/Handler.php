<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnsupportedMediaTypeHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [

    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (UnsupportedMediaTypeHttpException $e) {
            throw new JsonAPI\UnsupportedMediaTypeHttpException(
                $e->getMessage()
            );
        });

        $this->renderable(function (BadRequestHttpException $e) {
            throw new JsonAPI\BadRequestHttpException(
                $e->getMessage()
            );
        });

        $this->renderable(function (UnauthorizedException $e) {
            throw new JsonAPI\UnauthorizedException(
                $e->getMessage()
            );
        });

        $this->renderable(function (AuthenticationException $e) {
            throw new JsonAPI\AuthenticationException(
                $e->getMessage()
            );
        });

        $this->renderable(function (NotFoundHttpException $e) {
            throw new JsonAPI\NotFoundHttpException(
                $e->getMessage()
            );
        });

        $this->renderable(function (HttpException $e) {
            return response()->json([
                'errors' => [
                    [
                        'title' => 'Oops! Something went wrong.',
                        'detail' => $e->getMessage(),
                    ],
                ],
            ], $e->getStatusCode());
        });
    }

    public function invalidJson($request, ValidationException $exception): JsonResponse
    {
        $errors = collect($exception->errors())->map(fn ($error, $key) => [
            'title' => 'The given data was invalid.',
            'detail' => $error[0],
            'source' => [
                'pointer' => '/'.Str::of($key)->replace('.', '/')->value(),
            ],
        ])->values();

        return response()->json(
            data: [
                'errors' => $errors,
            ],
            status: $exception->status,
            headers: [
                'Content-Type' => 'application/json',
            ]
        );
    }
}
