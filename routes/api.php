<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
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

Route::prefix('app')->group(function() {
    Route::middleware('guest:sanctum')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
        Route::post('validate-code', [AuthController::class, 'validateCode']);
        Route::post('reset-password', [AuthController::class, 'resetPassword']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('me', [ProfileController::class, 'me']);
        Route::post('profile', [ProfileController::class, 'updateProfile']);
        Route::post('update-card', [ProfileController::class, 'updateCard']);
        Route::post('update-password', [ProfileController::class, 'updatePassword']);
        Route::get('logout', function (Request $request) {
            $request->user()->currentAccessToken()->delete();
            return response()->json(null, 204);
        });
    });
});
