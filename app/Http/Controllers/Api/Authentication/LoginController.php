<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\PersonalAccessTokenResult;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class LoginController extends Controller
{
    /**
     * Get User Credentials.
     *
     *
     * Este servicio nos  permite generar un token de acceso para consumir los servicios de la API.
     */
    #[OpenApi\Operation(tags: ['Authentication'])]
    public function __invoke(LoginRequest $request)
    {
        try {
            $token = auth()->attempt($request->only('email', 'password'));

            if (! $token) {
                abort(401, 'Invalid Credentials provided, verify your email and password and try again.');
            }

            $token = $this->createNewToken(Auth::user());

            return response()->json([
                'access_token' => $token->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => $token->token->expires_at->toDateTimeString(),
            ]);
        } catch (\Exception $e) {
            abort(400, $e->getMessage());
        }
    }

    private function createNewToken(User $user): PersonalAccessTokenResult
    {
        return $user->createToken('auth_token');
    }
}
