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

    public function login(Request $request) {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'device' => ['required'],
        ]);
        $member = Member::with(['profile', 'location', 'plan'])
            ->where('email', $request['email'])
            ->first();
        if (!$member || !Hash::check($request['password'], $member['password'])) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        if (!$member['active']) {
            throw ValidationException::withMessages([
                'email' => ['Your account has been deactivated.'],
            ]);
        }
        return response()->json([
            'access_token' => $member->createToken($request['device'])->plainTextToken,
            'user' => $member->getInfo($member),
        ]);
    }

    public function forgotPassword(Request $request) {
        $request->validate([
            'email' => ['required', 'email'],
        ]);
        $email = $request['email'];
        $member = Member::where('email', $email)
            ->active()
            ->first();
        if (!$member) {
            throw ValidationException::withMessages([
                'email' => ['The email does not exist.'],
            ]);
        }
        try {
            $reset = DB::table('member_password_reset_codes')
                ->where('email', $email)
                ->first();
            if (!$reset
                || $reset->created_at < date('Y-m-d H:i:s', strtotime("-{$this->code_expiration} minutes"))
            ) {
                $code = random_int(100000, 999999);
                DB::table('member_password_reset_codes')->updateOrInsert([
                    'email' => $email,
                ], [
                    'code' => $code,
                    'created_at' => now(),
                ]);
            }
            $member->notify(new MemberResetCode($code ?? $reset->code, $this->code_expiration));
        } catch (\Exception $exception) {
            throw ValidationException::withMessages([
                'email' => [$exception->getMessage()],
            ]);
        }
        return response()->json(null);
    }

    public function validateCode(Request $request) {
        $request->validate([
            'email' => ['required', 'email'],
            'code' => ['required', 'digits:6']
        ]);
        $reset = DB::table('member_password_reset_codes')
            ->where('email', $request['email'])
            ->where('code', $request['code'])
            ->where('created_at', '>=', date('Y-m-d H:i:s', strtotime("-{$this->code_expiration} minutes")))
            ->first();
        if (!$reset) {
            throw ValidationException::withMessages([
                'code' => 'Reset code is incorrect.',
            ]);
        }
        return response()->json(null);
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'email' => ['required', 'email'],
            'code' => ['required', 'digits:6'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);
        $email = $request['email'];
        $code = $request['code'];
        $reset = DB::table('member_password_reset_codes')
            ->where('email', $email)
            ->where('code', $code)
            ->where('created_at', '>=', date('Y-m-d H:i:s', strtotime("-{$this->code_expiration} minutes")))
            ->first();
        if (!$reset) {
            throw ValidationException::withMessages([
                'code' => 'Reset code is expired.',
            ]);
        }
        $member = Member::where('email', $email)
            ->active()
            ->first();
        if (!$member) {
            throw ValidationException::withMessages([
                'email' => ['The email does not exist.'],
            ]);
        }
        $member['password'] = bcrypt($request['password']);
        $member->save();
        DB::table('member_password_reset_codes')
            ->where('email', $email)
            ->where('code', $code)
            ->delete();
        return response()->json(null);
    }
}
