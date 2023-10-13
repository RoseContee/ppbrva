<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {

    Route::get('/members', [MemberController::class, 'index'])->name('members');
    Route::get('/members/add', [MemberController::class, 'add'])->name('addmember');
    Route::get('/activity', [MemberController::class, 'activity'])->name('activity');
    Route::get('/activity/add', [MemberController::class, 'addactivity'])->name('addactivity');
    Route::get('/invoices', [MemberController::class, 'invoices'])->name('invoices');
    Route::get('/invoices/{id}', [MemberController::class, 'invoicedetail'])->name('invoicedetail');
    Route::get('/locations', [LocationController::class, 'index'])->name('locations');
    Route::get('/locations/add', [LocationController::class, 'add'])->name('addlocation');
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments');
    Route::get('/users', [RegisteredUserController::class, 'index'])->name('users');
    Route::get('/users/add', [RegisteredUserController::class, 'add'])->name('adduser');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::get('/settings/plans', [SettingsController::class, 'plans'])->name('plans');
    Route::get('/settings/plans/add', [SettingsController::class, 'addplan'])->name('addplan');
    Route::get('/settings/roles', [SettingsController::class, 'roles'])->name('roles');
    Route::get('/settings/roles/add', [SettingsController::class, 'addrole'])->name('addrole');
    Route::get('/settings/appicons', [SettingsController::class, 'appicons'])->name('appicons');
});

require __DIR__.'/auth.php';
