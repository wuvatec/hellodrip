<?php

use App\Http\Controllers\Api\v1\AuthenticationController;
use App\Http\Controllers\Api\v1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::domain(config('app.api.subdomain'))->group(function () {

    // Version v1
    Route::prefix('v1')->group(function () {

        // Check API status
        Route::get('status', function () {
            return response('Ok!', 200);
        })->name('status');

        // Laravel sanctum api authentication
        Route::post('register', [AuthenticationController::class, 'register'])->name('register');
        Route::post('login', [AuthenticationController::class, 'login'])->name('login');
        Route::post('user', [AuthenticationController::class, 'user'])->name('user');
        Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');

        // Protected api routes
        Route::middleware('auth:sanctum')->group(function () {
            Route::apiResource('users', UserController::class);
        });

    });

});
