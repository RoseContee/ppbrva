<?php

namespace App\Http\Controllers\Api;

use App\Helpers\General;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Notifications\MemberResetCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
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
        General::memberForgotPassword($request);
        return response()->json([
            'status' => 'OK',
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function validateCode(Request $request) {
        $request->validate([
            'email' => ['required', 'email'],
            'code' => ['required', 'digits:6']
        ]);
        $code_expiration = General::$reset_code_expiration;
        $expiration = date('Y-m-d H:i:s', strtotime("-{$code_expiration} minutes"));
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
        General::memberResetPassword($request);
        return response()->json([
            'status' => 'OK',
        ]);
    }
}
