<?php

namespace App\Http\Controllers\Member;

use App\Helpers\General;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login() {
        return view('member.auth.login');
    }

    /**
     * @throws ValidationException
     */
    public function postLogin(Request $request) {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $throttleKey = Str::transliterate(Str::lower($request->input('email')).'|'.$request->ip());
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'email' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }
        if (!auth('member')->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            RateLimiter::hit($throttleKey);
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }
        $user = auth('member')->user();
        if (!in_array($user['status'], ['active', 'paused', 'suspended'])) {
            auth('member')->logout();
            throw ValidationException::withMessages([
                'email' => 'Your account has been deactivated.',
            ]);
        }
        RateLimiter::clear($throttleKey);
        return to_route('member.dashboard');
    }

    public function forgot() {
        return view('member.auth.forgot-password');
    }

    /**
     * @throws ValidationException
     */
    public function postForgot(Request $request) {
        General::memberForgotPassword($request);
        return to_route('member.password.reset');
    }

    public function reset() {
        return view('member.auth.reset-password');
    }

    /**
     * @throws ValidationException
     */
    public function postReset(Request $request) {
        $request->validate([
            'email' => ['required', 'email'],
            'code' => ['required'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);
        General::memberResetPassword($request);
        return to_route('member.login')->with('status', 'Please login with new password.');
    }
}
