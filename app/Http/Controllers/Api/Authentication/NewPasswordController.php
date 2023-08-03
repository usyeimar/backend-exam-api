<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Requests\Authentication\NewPasswordRequest;
use App\Services\Authentication\UpdatePasswordUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class NewPasswordController
{
    /** Handle an incoming new password request.
     * @throws ValidationException
     */
    public function __invoke(NewPasswordRequest $request, UpdatePasswordUser $updateUserPassword): JsonResponse
    {
        $updateUserPassword($request, Hash::make($request->get('password')));

        return response()->json([
            'message' => __('auth.password_updated'),
        ]);
    }
}
