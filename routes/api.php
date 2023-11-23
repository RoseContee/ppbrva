<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\InvoicesController;
use App\Http\Controllers\Api\MembersController;
use App\Http\Controllers\Api\SettingsController;
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
        Route::post('update-billing', [ProfileController::class, 'updateBilling']);
        Route::post('update-password', [ProfileController::class, 'updatePassword']);
        Route::post('plan-change-request', [ProfileController::class, 'planChangeRequest']);

        Route::get('invoices', [InvoicesController::class, 'invoices']);
        Route::get('invoices/{invoiceID}', [InvoicesController::class, 'invoiceDetail']);
        Route::get('invoices/{invoiceID}/download', [InvoicesController::class, 'invoiceDownload']);
        Route::get('activities', [InvoicesController::class, 'activities']);

        Route::get('members', [MembersController::class, 'members']);
        Route::get('friends', [MembersController::class, 'friends']);
        Route::get('pending-friends', [MembersController::class, 'pendingFriends']);
        Route::get('members/{memberID}', [MembersController::class, 'member']);
        Route::post('members/{memberID}/invite', [MembersController::class, 'invite']);
        Route::post('members/{memberID}/accept', [MembersController::class, 'accept']);
        Route::post('members/{memberID}/decline', [MembersController::class, 'decline']);
        Route::post('members/{memberID}/share-setting', [MembersController::class, 'shareSetting']);
        Route::post('members/{memberID}/remove', [MembersController::class, 'remove']);

        Route::prefix('settings')->group(function() {
            Route::get('dashboard', [SettingsController::class, 'dashboard']);
            Route::get('plans', [SettingsController::class, 'plans']);
            Route::get('kitchen-bars', [SettingsController::class, 'kitchenBars']);
        });

        Route::get('logout', function (Request $request) {
            $request->user()->currentAccessToken()->delete();
            return response()->json(null, 204);
        });
    });
});
