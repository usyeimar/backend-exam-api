<?php

namespace App\Services\Authentication;

use App\Models\User;
use Laravel\Passport\PersonalAccessTokenResult;

class LoginService
{
    public function __invoke(?User $user): array
    {
        $token = [
            'token' => $this->createToken($user)->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => $this->createToken($user)->token->expires_at->toDateTimeString(),
        ];

        return [
            'status' => __('auth.success'),
            'message' => 'User logged in successfully',
            'user' => $user,
            ...$token,
        ];
    }

    protected function createToken(User $user): PersonalAccessTokenResult
    {
        return $user->createToken(
            'App',
            // Here you can customize the scopes for a new user
        );
    }
}
