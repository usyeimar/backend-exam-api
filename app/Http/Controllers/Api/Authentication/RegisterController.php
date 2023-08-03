<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Exceptions\JsonAPI\BadRequestHttpException;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Traits\HasToShowApiTokens;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class RegisterController extends Controller
{
    use HasToShowApiTokens;

    /**
     * Register a new user.
     *
     * Este servicio nos permite automatizar el proceso de registro de un usuario.
     *
     * @throws BadRequestHttpException
     */
    #[OpenApi\Operation(tags: ['Authentication'])]
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        try {

            $user = User::query()->create([
                'first_name' => $request->get('first_name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);

            //          $user->sendEmailVerificationNotification();

            // You can customize on config file if the user would show token on register to directly register and login at once.
            return $this->showCredentials($user, 201);
        } catch (Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
