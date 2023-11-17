<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Clover;
use App\Helpers\Dupr;
use App\Http\Controllers\Controller;
use App\Mail\PlanChangeRequest;
use App\Models\Member;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function me() {
        $user = Member::query()
            ->with(['profile', 'location', 'plan'])
            ->find(auth()->id());
        return response()->json([
            'user' => $user->getInfo(),
        ]);
    }

    public function updateProfile(Request $request) {
        $request->validate([
            'avatar' => ['nullable', 'image'],
            'name' => ['required'],
            'email' => ['required'],
        ]);
        $user = Member::query()
            ->with(['profile', 'location', 'plan'])
            ->find(auth()->id());
        if ($user['name'] != $request['name']
            || $user['email'] != $request['email']
            || $user['phone'] != $request['phone']
        ) {
            $clover = new Clover();
            $customer = $clover->getCustomer($user['customerID']);
            if (!empty($customer['id'])) {
                $customer = $clover->updateCustomer($user['customerID'], [
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
            /*} else {
                $customer = $clover->createCustomer([
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'phone' => $request['phone'],
                ]);*/
            }
            if (empty($customer['id'])) {
                return response()->json(['message' => $customer], 400);
            }
            $user['name'] = $request['name'];
            $user['email'] = $request['email'];
            $user['phone'] = $request['phone'];
        }
        if ($request->hasFile('avatar')) {
            $user->removeAvatar();
            $user['avatar'] = 'uploads/'.$request->file('avatar')->store('avatars');
        }
        $user->save();
        $profile = $user['profile'];
        $profile['share_age_gender'] = $request['share'] === 'true';
        if ($profile['dupr_id'] != $request['dupr']) {
            if ($profile['dupr_id'] = $request['dupr']) {
                $dupr = new Dupr();
                $duprInfo = $dupr->getPlayInfo($profile['dupr_id']);
            }
            $profile['gender'] = $duprInfo['gender'] ?? null;
            $profile['age'] = $duprInfo['age'] ?? null;
            $profile['rating'] = $duprInfo['rating'] ?? null;
            $profile['matches'] = $duprInfo['matches'] ?? null;
            $profile['wins'] = $duprInfo['wins'] ?? null;
            $profile['losses'] = $duprInfo['losses'] ?? null;
        }
        $profile->save();
        return response()->json([
            'user' => $user->getInfo(),
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
        $user = Member::query()
            ->with(['profile', 'location', 'plan'])
            ->find(auth()->id());
        $clover = new Clover();
        $expires = explode('/', $request['expires']);
        $brand = $clover->cardType($request['number']);
        $card = $clover->createCardToken([
            'number' => $request['number'],
            'exp_month' => $expires[0],
            'exp_year' => $expires[1],
            'cvv' => $request['cvv'],
            'brand' => $brand,
            'address' => $request['address'],
            'zipcode' => $request['zipcode'],
        ]);
        if (empty($card['id'])) {
            return response()->json(['message' => $card], 400);
        }
        $customer = $clover->getCustomer($user['customerID']);
        if (empty($customer['id'])) {
            return response()->json(['message' => $customer], 400);
        }
        if ($cardId = $customer['cards']['elements'][0]['id'] ?? '') {
            $clover->revokeCustomerCard($user['customerID'], $cardId);
        }
        $customer = $clover->updateCustomerCard($user['customerID'], [
            'email' => $user['email'],
            'card' => $card['id'],
        ]);
        if (empty($customer['id'])) {
            return response()->json(['message' => $customer], 400);
        }
        $user['card_type'] = strtolower($brand);
        $user['card_last4'] = substr($request['number'], -4);
        $user->save();
        return response()->json([
            'user' => $user->getInfo(),
        ]);
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'password' => ['required', 'min:8', 'confirmed'],
        ]);
        $user = $request->user();
        $user['password'] = bcrypt($request['password']);
        $user['original_pass'] = null;
        $user->save();
        return response()->json([
            'status' => 'OK'
        ]);
    }

    public function planChangeRequest(Request $request) {
        $user = $request->user();
        $request->validate([
            'plan' => [
                'required',
                'exists:plans,id',
                Rule::notIn([$user['plan_id']]),
            ],
        ], [
            'plan.notIn' => 'Please select another plan.',
        ]);
        try {
            $plan = Plan::query()->find($request['plan']);
            Mail::to('info@divstrong.com')->send(new PlanChangeRequest([
                'member' => $user,
                'plan' => $plan['name'],
            ]));
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Something went wrong. Please try again later.',
            ], 500);
        }
        return response()->json([
            'status' => 'OK',
        ]);
    }
}
