<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
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
        $member['original_pass'] = !empty($member['original_pass']);
        if ($member['avatar'] && file_exists(public_path($member['avatar']))) {
            $member['avatar'] = asset($member['avatar']);
        } else {
            $member['avatar'] = null;
        }
        return response()->json([
            'access_token' => $member->createToken($request['device'])->plainTextToken,
            'user' => $member,
        ]);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(null, 204);
    }
}
