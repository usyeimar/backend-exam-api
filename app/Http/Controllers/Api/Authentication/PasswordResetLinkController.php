<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\PasswordResetLinkRequest;
use App\Notifications\ResetPasswordNotification;
use App\Services\Authentication\AddPasswordResetToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class PasswordResetLinkController extends Controller
{
    public function __invoke(PasswordResetLinkRequest $request, AddPasswordResetToken $resetTokenAction): JsonResponse
    {
        $user = $request->getSaveUser();
        $token = Str::random(60);
        $resetTokenAction($user, $token);
        $user->notify(new ResetPasswordNotification($token));

        return response()->json([
            'success' => true,
            'message' => 'Password reset link sent successfully',
        ]);
    }
}
