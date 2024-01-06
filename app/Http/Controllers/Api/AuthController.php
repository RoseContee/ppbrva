<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Notifications\MemberResetCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected int $code_expiration = 60;

    /**
     * @throws ValidationException
     */
    public function login(Request $request) {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'device' => ['required'],
        ]);
        $user = Member::query()
            ->with(['profile'])
            ->where('email', $request['email'])
            ->where('status', '<>', 'pending')
            ->first();
        if (!$user || !Hash::check($request['password'], $user['password'])) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        if ($user['status'] == 'inactive') {
            throw ValidationException::withMessages([
                'email' => ['Your account has been deactivated.'],
            ]);
        }
        return response()->json([
            'access_token' => $user->createToken($request['device'])->plainTextToken,
            'user' => $user->getInfo(),
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function forgotPassword(Request $request) {
        $request->validate([
            'email' => ['required', 'email'],
        ]);
        $user = Member::query()
            ->where('email', $request['email'])
            ->where('status', 'active')
            ->first();
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['The email does not exist.'],
            ]);
        }
        try {
            $reset = DB::table('member_password_reset_codes')
                ->where('email', $request['email'])
                ->first();
            $expiration = date('Y-m-d H:i:s', strtotime("-{$this->code_expiration} minutes"));
            if (!$reset || $reset->created_at < $expiration) {
                $code = random_int(100000, 999999);
                DB::table('member_password_reset_codes')->updateOrInsert([
                    'email' => $request['email'],
                ], [
                    'code' => $code,
                    'created_at' => now(),
                ]);
            }
            $user->notify(new MemberResetCode([
                'code' => $code ?? $reset->code,
                'expiration' => $this->code_expiration,
            ]));
        } catch (\Exception $exception) {
            throw ValidationException::withMessages([
                'email' => [$exception->getMessage()],
            ]);
        }
        return response()->json([
            'status' => 'OK',
        ]);
    }

    public function validateCode(Request $request) {
        $request->validate([
            'email' => ['required', 'email'],
            'code' => ['required', 'digits:6']
        ]);
        $expiration = date('Y-m-d H:i:s', strtotime("-{$this->code_expiration} minutes"));
        $reset = DB::table('member_password_reset_codes')
            ->where('email', $request['email'])
            ->where('code', $request['code'])
            ->where('created_at', '>=', $expiration)
            ->first();
        if (!$reset) {
            throw ValidationException::withMessages([
                'code' => 'Reset code is incorrect.',
            ]);
        }
        return response()->json([
            'status' => 'OK',
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function resetPassword(Request $request) {
        $request->validate([
            'email' => ['required', 'email'],
            'code' => ['required', 'digits:6'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);
        $expiration = date('Y-m-d H:i:s', strtotime("-{$this->code_expiration} minutes"));
        $reset = DB::table('member_password_reset_codes')
            ->where('email', $request['email'])
            ->where('code', $request['code'])
            ->where('created_at', '>=', $expiration)
            ->first();
        if (!$reset) {
            throw ValidationException::withMessages([
                'code' => 'Reset code is expired.',
            ]);
        }
        $user = Member::query()
            ->where('email', $request['email'])
            ->where('status', 'active')
            ->first();
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['The email does not exist.'],
            ]);
        }
        $user['password'] = bcrypt($request['password']);
        $user['original_pass'] = null;
        $user->save();
        DB::table('member_password_reset_codes')
            ->where('email', $request['email'])
            ->where('code', $request['code'])
            ->delete();
        return response()->json([
            'status' => 'OK',
        ]);
    }
}
