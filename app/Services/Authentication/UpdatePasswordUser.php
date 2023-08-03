<?php

namespace App\Services\Authentication;

use App\Http\Requests\Authentication\NewPasswordRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

final class UpdatePasswordUser
{
    /**
     * @throws ValidationException
     */
    public function __invoke(NewPasswordRequest $request, $password): void
    {
        $user = $request->getUserByToken();
        $user->update(compact('password'));
        DB::table('password_resets')
            ->where('email', $user->email)
            ->delete();
    }
}
