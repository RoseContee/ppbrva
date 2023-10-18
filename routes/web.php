<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Settings\IndexController as SettingsController;
use App\Http\Controllers\Settings\PlanController;
use App\Http\Controllers\Settings\RoleController;
use App\Http\Controllers\Settings\AppiconsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth', 'role'])->group(function () {
    Route::get('/', function() {
        return redirect()->route('dashboard');
    });
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['verified']);

    Route::resources([
        'locations' => LocationController::class,
        'members'   => MemberController::class,
        'activity' => ActivityController::class,
        'invoices' => InvoicesController::class,
        'users'     => UsersController::class,
    ]);
    Route::post('members/send-invite', [MemberController::class, 'sendInvite'])->name('members.send-invite');
    Route::delete('members', [MemberController::class, 'destroy'])->name('members.destroy');
    Route::delete('users', [UsersController::class, 'destroy'])->name('users.destroy');

    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
        Route::resources([
            'plans' => PlanController::class,
            'roles' => RoleController::class,
            'appicons' => AppiconsController::class,
        ], [
            'as' => 'settings'
        ]);
        Route::delete('plans', [PlanController::class, 'destroy'])->name('settings.plans.destroy');
        Route::delete('roles', [RoleController::class, 'destroy'])->name('settings.roles.destroy');
    });

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
