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
            'user' => $member->getInfo(),
        ]);
    }

    public function updateProfile(Request $request) {
        $request->validate([
            'avatar' => ['nullable', 'image'],
            'name' => ['required'],
            'email' => ['required'],
        ]);
        $member = $request->user();
        if ($member['name'] != $request['name']
            || $member['email'] != $request['email']
            || $member['phone'] != $request['phone']
        ) {
            $clover = new Clover();
            $customer = $clover->getCustomer($member['customer_id']);
            if (empty($customer['id'])) {
                return response()->json(['message' => $customer], 400);
            }
            $customer = $clover->updateCustomer($member['customer_id'], [
                'name' => $request['name'],
                'email' => [
                    'id' => $customer['emailAddresses']['elements'][0]['id'] ?? '',
                    'value' => $request['email'],
                ],
                'phone' => [
                    'id' => $customer['phoneNumbers']['elements'][0]['id'] ?? '',
                    'value' => $request['phone'],
                ],
            ]);
            if (empty($customer['id'])) {
                return response()->json(['message' => $customer], 400);
            }
            $member['name'] = $request['name'];
            $member['email'] = $request['email'];
            $member['phone'] = $request['phone'];
        }
        if ($request->hasFile('avatar')) {
            $member->removeAvatar();
            $member['avatar'] = 'uploads/'.$request->file('avatar')->store('avatars');
        }
        $member->save();
        $member->profile()->updateOrCreate([
            'member_id' => $member['id'],
        ], [
            'share_age_gender' => !empty($request['share']),
        ]);
        return response()->json([
            'user' => $member->getInfo(),
        ]);
    }

    public function updateBilling(Request $request) {
        $request['number'] = str_replace(' ', '', $request['number']);
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
        $expires = explode('/', $request['expires']);
        $member = $request->user();
        $clover = new Clover();
        $brand = $clover->cardType($request['number']);
        $card = $clover->createCardToken([
            'number' => $request['number'],
            'exp_month' => $expires[0],
            'exp_year' => $expires[1],
            'cvv' => $request['cvv'],
            'brand' => $brand,
            'name' => $member['name'],
            'address' => $request['address'],
            'zipcode' => $request['zipcode'],
        ]);
        if (empty($card['id'])) {
            return response()->json(['message' => $card], 400);
        }
        $customer = $clover->getCustomer($member['customer_id']);
        if (empty($customer['id'])) {
            return response()->json(['message' => $customer], 400);
        }
        if ($cardId = $customer['cards']['elements'][0]['id'] ?? '') {
            $clover->revokeCustomerCard($member['customer_id'], $cardId);
        }
        $customer = $clover->updateCustomerCard($member['customer_id'], [
            'email' => $member['email'],
            'card' => $card['id'],
        ]);
        if (empty($customer['id'])) {
            return response()->json(['message' => $customer], 400);
        }
        $member['card_type'] = strtolower($brand);
        $member['card_last4'] = substr($request['number'], -4);
        $member->save();
        return response()->json([
            'user' => $member->getInfo(),
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
