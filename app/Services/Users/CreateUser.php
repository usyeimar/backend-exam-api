<?php

namespace App\Services\Users;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class CreateUser
{
    /**
     * Create a new user
     * @param array $data
     * @return JsonResponse
     */
    public function __invoke(
        array $data
    ): JsonResponse {
        $user = User::create(
            array_filter([
                'first_name' => $data['first_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'last_name' => $data['last_name'] ?? null,
            ])
        );


        //send email
        // $user->sendEmailVerificationNotification();

        return response()->json([
            'user' => $user,
        ]);
    }
}
