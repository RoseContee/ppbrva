<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function me(Request $request) {
        $member = $request->user();
        if ($member['avatar'] && file_exists(public_path($member['avatar']))) {
            $member['avatar'] = asset($member['avatar']);
        } else {
            $member['avatar'] = null;
        }
        $profile = $member['profile'];
        $location = $member['location'];
        $plan = $member['plan'];
        return response()->json([
            'user' => $member,
        ]);
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'password' => ['required', 'min:8', 'confirmed'],
        ]);
        $member = $request->user();
        $member['password'] = bcrypt($request['password']);
        $member['original_pass'] = null;
        $member->save();
        return response()->json(null);
    }
}
