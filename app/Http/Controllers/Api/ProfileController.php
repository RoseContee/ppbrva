<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Clover;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function me(Request $request) {
        $member = $request->user();
        return response()->json([
            'user' => $member->getInfo($member),
        ]);
    }

    public function updateProfile(Request $request) {
        $request->validate([
            'name' => ['required'],
            'email' => ['required'],
        ]);
        $member = $request->user();
        $member['name'] = $request['name'];
        $member['email'] = $request['email'];
        $member['phone'] = $request['phone'];
        $member->save();
        $member->profile()->updateOrCreate([
            'member_id' => $member['id'],
        ], [
            'share_age_gender' => !empty($request['share']),
        ]);
        return response()->json([
            'user' => $member->getInfo($member),
        ]);
    }

    public function updateCard(Request $request) {
        $request->validate([
            'number' => ['required'],
            'expires' => ['required', 'date_format:m/y'],
            'cvv' => ['required', 'numeric'],
            'address' => ['required'],
            'zipcode' => ['required'],
        ], [
            'number.required' => 'The card number field is required.',
            'expires.date_format' => 'The expires field must match the format MM/YY.',
        ]);
        $member = $request->user();
        $clover = new Clover();
        if ($member['card_id']) {
            $response = $clover->revokeCard($member['customer_id'], $member['card_id']);
            logger('revoke card');
            logger($response);
            if (!$response) {
                $customer = $clover->getCustomer($member['customer_id']);
                if (!empty($customer['cards']['elements'][0])) {
                    $clover->revokeCard($member['customer_id'], $customer['cards']['elements'][0]);
                }
            }
        }
        return response()->json([
            'user' => $member->getInfo($member),
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
