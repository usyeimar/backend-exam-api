<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Helpers\PassportRevokerHelper;
use App\Http\Controllers\Controller;
use App\OpenApi\SecuritySchemes\ApiAuthorizationTokenSecurityScheme;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class LogoutController extends Controller
{
    /**
     * Logout the user.
     *
     * Este servicio nos permite cerrar la sesión de un usuario.
     */
    #[OpenApi\Operation(tags: ['Authentication'], security: ApiAuthorizationTokenSecurityScheme::class)]
    public function __invoke(Request $request): Response
    {
        PassportRevokerHelper::create(
            user: Auth::user(),
        )->deleteCurrentToken();

        return response()->noContent();

    }
}
