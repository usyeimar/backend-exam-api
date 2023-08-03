<?php

use App\Http\Controllers\Api\Authentication\ConfirmablePasswordController;
use App\Http\Controllers\Api\Authentication\LoginController;
use App\Http\Controllers\Api\Authentication\LogoutController;
use App\Http\Controllers\Api\Authentication\NewPasswordController;
use App\Http\Controllers\Api\Authentication\PasswordResetLinkController;
use App\Http\Controllers\Api\Authentication\RegisterController;
use App\Http\Controllers\Api\v1\Customers\CustomerControllers;
use App\Http\Controllers\Api\v1\Users\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('login', LoginController::class)
        ->name('auth.login');
    Route::post('register', RegisterController::class)
        ->name('auth.register');

    Route::post('/forgot-password', PasswordResetLinkController::class)
        ->name('auth.forgot-password');

    Route::post('/reset-password', NewPasswordController::class)
        ->name('auth.reset-password');

    //Route::post('/email/verification-notification', EmailVerificationNotificationController::class)
    //    ->middleware(['auth:sanctum', 'throttle:6,1'])
    //    ->name('api.v1.verification.send');
    //
    //Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    //    ->middleware(['signed', 'throttle:6,1'])
    //    ->name('api.v1.verification.verify');

    Route::post('/confirm-password', ConfirmablePasswordController::class)
        ->middleware('auth:sanctum')
        ->name('auth.confirm-password');

    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('logout', LogoutController::class)
            ->name('auth.logout');
        Route::get('me', function (Request $request) {
            return $request->user();
        })
            ->name('auth.me');
    });
});

Route::prefix('v1')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('customers', CustomerControllers::class)
            ->parameter('customers', 'customer_id')
            ->names('api.v1.customers');

        Route::apiResource('users', UsersController::class)
            ->parameter('users', 'user_id')
            ->names('api.v1.users');
    });
