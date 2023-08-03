<?php

namespace App\Http\Controllers\Api\v1\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\OpenApi\SecuritySchemes\ApiAuthorizationTokenSecurityScheme;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class UsersController extends Controller
{
    /**
     * Obtener todos los usuarios
     */
    #[OpenApi\Operation(tags: ['Users'], security: ApiAuthorizationTokenSecurityScheme::class)]
    public function index()
    {
        try {
            $users = User::all();

            return response()->json([
                'users' => $users,
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * Crear un nuevo recurso
     */
    #[OpenApi\Operation(tags: ['Users'], security: ApiAuthorizationTokenSecurityScheme::class)]
    public function store(Request $request)
    {
        try {
            $user = User::query()->create($request->all());

            return response()->json([
                'user' => $user,
            ], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * Mostrar un recurso por su ID
     *
     * @param  string  $id - ID del recurso a mostrar
     */
    #[OpenApi\Operation(tags: ['Users'], security: ApiAuthorizationTokenSecurityScheme::class)]
    public function show(string $id)
    {
        try {
            $user = User::query()->findOrFail($id);

            return response()->json([
                'user' => $user,
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }

    /**
     *Actualizar un recurso por su ID
     *
     * @param  string  $id - ID del recurso a actualizar
     */
    #[OpenApi\Operation(tags: ['Users'], security: ApiAuthorizationTokenSecurityScheme::class)]
    public function update(Request $request, string $id)
    {
        try {
            $user = User::query()->findOrFail($id);
            $user->update($request->all());

            return response()->json([
                'user' => $user,
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * Eliminar un recurso por su ID
     *
     * @param  string  $id - ID del recurso a eliminar
     */
    #[OpenApi\Operation(tags: ['Users'], security: ApiAuthorizationTokenSecurityScheme::class)]
    public function destroy(string $id)
    {
        try {
            $user = User::query()->findOrFail($id);
            $user->delete();

            return response()->json([
                'user' => $user,
            ]);
        } catch (ModelNotFoundException $exception) {
            abort(404, 'No se encontraron resultados para el recurso con id '.$id);
        }

    }
}
