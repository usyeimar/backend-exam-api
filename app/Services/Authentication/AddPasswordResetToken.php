<?php

namespace App\Services\Authentication;

use Illuminate\Support\Facades\DB;

final class AddPasswordResetToken
{
    public function __invoke($user, $token): void
    {
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();
        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now(),
        ]);
    }
}
