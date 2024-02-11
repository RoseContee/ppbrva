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
use App\Http\Controllers\Settings\CategoryController;
use App\Http\Controllers\Settings\AppSettingsController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Member\AuthController as MemberAuth;
use App\Http\Controllers\Member\DashboardController as MemberDashboard;
use App\Http\Controllers\Member\InvoiceController as MemberInvoice;
use App\Http\Controllers\Member\ProfileController as MemberProfile;
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

Route::get('join', [MemberController::class, 'joinForm'])->name('members.join');
Route::post('join', [MemberController::class, 'join']);
Route::get('thanks', [MemberController::class, 'thanks'])->name('members.thanks');

Route::middleware(['auth', 'active', 'role'])->group(function () {
    Route::get('/', function() {
        return to_route('dashboard');
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
    Route::post('members/approve', [MemberController::class, 'approve'])->name('members.approve');
    Route::delete('members', [MemberController::class, 'destroy'])->name('members.destroy');
    Route::get('invoices/{id}/download', [InvoicesController::class, 'download'])->name('invoices.download');
    Route::post('invoices/{id}/pay', [InvoicesController::class, 'pay'])->name('invoices.pay');
    Route::delete('users', [UsersController::class, 'destroy'])->name('users.destroy');

    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
        Route::resources([
            'plans' => PlanController::class,
            'roles' => RoleController::class,
            'categories' => CategoryController::class,
        ], [
            'as' => 'settings'
        ]);
        Route::delete('plans', [PlanController::class, 'destroy'])->name('settings.plans.destroy');
        Route::delete('roles', [RoleController::class, 'destroy'])->name('settings.roles.destroy');
        Route::delete('categories', [CategoryController::class, 'destroy'])->name('settings.categories.destroy');

        Route::get('app-dashboard', [AppSettingsController::class, 'dashboard'])->name('settings.app-dashboard.index');
        Route::post('app-dashboard', [AppSettingsController::class, 'storeDashboard'])->name('settings.app-dashboard.store');

        Route::get('social-media', [AppSettingsController::class, 'socialMedia'])->name('settings.social-media.index');
        Route::post('social-media', [AppSettingsController::class, 'storeSocialMedia'])->name('settings.social-media.store');

        Route::get('general', [SettingsController::class, 'general'])->name('settings.general.index');
        Route::post('general', [SettingsController::class, 'storeGeneral'])->name('settings.general.store');
    });

    Route::get('emails/sent', [EmailController::class, 'sent'])->name('emails.sent');
    Route::get('emails/draft', [EmailController::class, 'draft'])->name('emails.draft');
    Route::get('emails/trash', [EmailController::class, 'trash'])->name('emails.trash');
    Route::get('emails/read/{id}', [EmailController::class, 'read'])->name('emails.read');
    Route::post('emails/send', [EmailController::class, 'send'])->name('emails.send');
    Route::post('emails/save-as-draft', [EmailController::class, 'saveDraft'])->name('emails.save-as-draft');
    Route::post('email/discard', [EmailController::class, 'discard'])->name('emails.discard');
    Route::delete('emails', [EmailController::class, 'destroy'])->name('emails.destroy');
    Route::delete('emails/attachment', [EmailController::class, 'destroyAttachment'])->name('emails.destroy-attachment');
    Route::post('emails/restore', [EmailController::class, 'restore'])->name('emails.restore');

    Route::resource('scan', ScanController::class)->only(['index', 'store']);
    Route::get('missingcc', [ScanController::class, 'missingcc'])->name('missingcc');

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('member')->name('member.')->group(function () {
    Route::middleware(['guest:member'])->group(function () {
        Route::get('login', [MemberAuth::class, 'login'])->name('login');
        Route::post('login', [MemberAuth::class, 'postLogin']);
        Route::get('forgot-password', [MemberAuth::class, 'forgot'])->name('password.forgot');
        Route::post('forgot-password', [MemberAuth::class, 'postForgot']);
        Route::get('reset-password', [MemberAuth::class, 'reset'])->name('password.reset');
        Route::post('reset-password', [MemberAuth::class, 'postReset']);
    });

    Route::middleware(['auth:member', 'active:member'])->group(function () {
        Route::get('/', function() {
            return to_route('member.dashboard');
        });
        Route::get('dashboard', [MemberDashboard::class, 'index'])->name('dashboard');

        Route::get('invoices', [MemberInvoice::class, 'index'])->name('invoices.index');
        Route::get('invoices/{id}', [MemberInvoice::class, 'show'])->name('invoices.show');
        Route::get('invoices/{id}/download', [MemberInvoice::class, 'download'])->name('invoices.download');

        Route::get('profile', [MemberProfile::class, 'index'])->name('profile');
        Route::post('profile', [MemberProfile::class, 'store']);

        Route::get('logout', function () {
            auth('member')->logout();
            return to_route('member.login');
        })->name('logout');
    });
});

require __DIR__.'/auth.php';
