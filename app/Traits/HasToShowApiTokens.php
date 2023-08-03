<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Laravel\Passport\PersonalAccessTokenResult;

trait HasToShowApiTokens
{
    public function showCredentials(User $user, int $code = 200, bool $showToken = true): JsonResponse
    {
        $response = [
            'message' => 'User logged in successfully',
        ];

        if ($showToken) {
            $token = $this->createToken($user);
            $response['access_token'] = $token->accessToken;
            $response['token_type'] = 'Bearer';
            $response['expires_at'] = $token->token->expires_at->toDateTimeString();
        }

        return response()->json($response, $code);
    }

    protected function createToken(User $user): PersonalAccessTokenResult
    {
        return $user->createToken(
            'App',
            // Here you can customize the scopes for a new user
        );

    }
}
