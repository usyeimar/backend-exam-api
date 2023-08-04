<?php

namespace App\Http\Controllers\Api\v1\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\OpenApi\SecuritySchemes\ApiAuthorizationTokenSecurityScheme;
use App\Services\Users\CreateUser;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class UsersController extends Controller
{
    /**
     * Get all users
     */
    #[OpenApi\Operation(tags: ['Users'], security: ApiAuthorizationTokenSecurityScheme::class)]
    public function index()
    {
        try {
            $users = User::query()
                ->paginate();

            return response()->json([
                'users' => $users,
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * Create a new user
     */
    #[OpenApi\Operation(tags: ['Users'], security: ApiAuthorizationTokenSecurityScheme::class)]
    public function store(CreateUserRequest $request, CreateUser $createUser)
    {
        try {
            return $createUser(
                data: $request->validated()
            );
        } catch (\Exception $exception) {
            return response()->json([
                'errors' => [
                    [
                        'title' => 'Ooops!, algo salió mal',
                        'detail' => $exception->getMessage(),
                    ],
                ],
            ], 400);
        }
    }

    /**
     * Get a user by id
     *
     * @param  string  $id - ID del recurso a mostrar
     */
    #[OpenApi\Operation(tags: ['Users'], security: ApiAuthorizationTokenSecurityScheme::class)]
    public function show(string $id)
    {
        try {
            return User::query()->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'errors' => [
                    [
                        'title' => 'Ooops!, algo salió mal',
                        'detail' => 'No found this resource with id '.$id.'.',
                    ],
                ],
            ], 400);
        }

    }

    /**
     *Update a user by id
     *
     * @param  string  $id - ID del recurso a actualizar
     */
    #[OpenApi\Operation(tags: ['Users'], security: ApiAuthorizationTokenSecurityScheme::class)]
    public function update(Request $request, string $id)
    {
        try {
            $user = User::query()->findOrFail($id);
            $user->fill($request->all());
            $user->save();

            return $user;
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'errors' => [
                    [
                        'title' => 'Ooops!, algo salió mal',
                        'detail' => 'No found this resource with id '.$id.'.',
                    ],
                ],
            ], 404);
        } catch (\Exception $exception) {
            return response()->json([
                'errors' => [
                    [
                        'title' => 'Ooops!, algo salió mal',
                        'detail' => $exception->getMessage(),
                    ],
                ],
            ], 400);
        }
    }

    /**
     *Delete a user By id
     *
     * @param  string  $id - ID del recurso a eliminar
     */
    #[OpenApi\Operation(tags: ['Users'], security: ApiAuthorizationTokenSecurityScheme::class)]
    public function destroy(string $id)
    {
        try {
            $user = User::query()->findOrFail($id);
            $user->delete();

            return $user;
        } catch (ModelNotFoundException $exception) {
            abort(404, 'No se encontraron resultados para el recurso con id '.$id);
        } catch (Exception $exception) {
            return response()->json([
                'errors' => [
                    [
                        'title' => 'Ooops!, algo salió mal',
                        'detail' => $exception->getMessage(),
                    ],
                ],
            ], 400);
        }

    }
}
