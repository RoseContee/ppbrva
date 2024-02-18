<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Clover;
use App\Helpers\General;
use App\Helpers\PodPlay;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Location;
use App\Models\Member;
use App\Models\MemberDevice;
use App\Models\Plan;
use App\Models\Setting;
use App\Rules\Phone as PhoneRule;
use App\Rules\State as StateRule;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function me(Request $request) {
        $user = $request->user();
        return response()->json([
            'user' => $user->getInfo(),
        ]);
    }

    public function saveDeviceToken(Request $request) {
        $request->validate([
            'device_token' => ['required'],
        ]);
        MemberDevice::query()->updateOrCreate([
            'token' => $request['device_token'],
        ], [
            'member_id' => auth()->id(),
            'device' => $request['device'],
        ]);
        return response()->json([
            'status' => 'OK',
        ]);
    }

    public function location(Request $request) {
        $user = $request->user();
        $location = Location::query()->find($user['location_id']);
        return response()->json([
            'location' => [
                'name' => $location['name'],
                'address' => $location['address'],
                'lat' => $location['lat'],
                'lng' => $location['lng'],
                'phone' => $location['phone'],
                'email' => $location['email'],
                'website' => $location['website'],
                'image' => $location['image'],
            ],
        ]);
    }

    public function plan(Request $request) {
        $user = $request->user();
        $plan = Plan::query()->find($user['plan_id']);
        return response()->json([
            'plan' => [
                'id' => $plan['id'],
                'name' => $plan['name'],
                'family' => $plan['id'] == Plan::FamilyPlanId && !$user['primary_id'],
            ],
        ]);
    }

    public function updateProfile(Request $request) {
        $user = $request->user();
        $request->validate([
            'avatar' => ['nullable', 'image'],
            'firstname' => ['required'],
            'lastname' => ['required'],
            'gender' => ['required', 'in:male,female,prefer_not_to_say'],
            'email' => ['required', 'email', Rule::unique('members')->ignore($user['id'])],
            'phone' => ['nullable', new PhoneRule],
            'dob' => ['required', 'dateFormat:m/d/Y'],
            'address' => ['required'],
            'city' => ['required'],
            'state' => ['required', new StateRule],
            'zipcode' => ['required'],
            'share' => ['required', 'in:true,false'],
        ]);
        $user = General::updateMember($user, $request);
        if (empty($user['id'])) {
            return response()->json(['message' => $user], 400);
        }
        $user->save();
        $profile = $user['profile'];
        $profile['share_age_gender'] = $request['share'] === 'true';
        if ($profile['dupr_id'] != $request['dupr']) {
            General::saveDUPR($profile, $request['dupr']);
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
        $expires = explode('/', $request['expires']);
        $clover = new Clover();
        $card = $clover->createCardToken([
            'number' => $request['number'],
            'exp_month' => $expires[0],
            'exp_year' => $expires[1],
            'cvv' => $request['cvv'],
            'brand' => ($brand = $clover->cardType($request['number'])),
            'address' => $request['address'],
            'zipcode' => $request['zipcode'],
        ]);
        if (empty($card['id'])) {
            return response()->json(['message' => $card], 400);
        }
        $user = $request->user();
        $customer = $clover->getCustomer($user['customerID']);
        if (empty($customer['id'])) {
            return response()->json(['message' => 'Customer ID not found'], 400);
        }
        foreach ($customer['cards']['elements'] ?? [] as $item) {
            if ($cardId = $item['id'] ?? '') {
                $clover->revokeCustomerCard($user['customerID'], $cardId);
            }
        }
        $customer = $clover->updateCustomerCard($user['customerID'], [
            'email' => $user['email'],
            'card' => $card['id'],
        ]);
        if (empty($customer['id'])) {
            return response()->json(['message' => $customer], 400);
        }
        $user['card_type'] = strtolower($card['card']['brand'] ?? $brand);
        $user['card_last4'] = substr($card['card']['last4'] ?? $request['number'], -4);
        $user->save();
        $podplay = new PodPlay();
        $podplay->createMembership($user);
        return response()->json([
            'user' => $user->getInfo(),
        ]);
    }

    public function firstPayment(Request $request) {
        $user = $request->user();
        $message = 'The member does not have a Card.';
        if ($user['card_last4']) {
            $period = date('F Y');
            $now = now();
            $days = $now->daysInMonth;
            $rate = (float)number_format(($user['plan']['price'] ?? 0) / $days, 2);
            $amount = (float)number_format($rate * ($days - $now->day), 2);
            $clover = new Clover();
            $charge = $clover->createCharge([
                'amount' => $amount,
                'source' => $user['customerID'],
                'description' => "PPBRVA {$period} first payment for {$user['name']}",
            ]);
            if (!empty($charge['paid'])) {
                $card_type = strtolower($charge['source']['brand']);
                $card_last4 = strtolower($charge['source']['last4']);
                $paid_at = gmdate('Y-m-d H:i:s', $charge['created'] / 1000);
                if ($user['card_type'] != $card_type || $user['card_last4'] != $card_last4) {
                    $user->update([
                        'card_type' => $card_type,
                        'card_last4' => $card_last4,
                    ]);
                }
                Invoice::query()->create([
                    'invoiceID' => $charge['id'],
                    'member_id' => $user['id'],
                    'period' => $period,
                    'amount' => $amount,
                    'paid' => true,
                    'card_type' => $card_type,
                    'card_last4' => $card_last4,
                    'paid_at' => $paid_at,
                    'reason' => null,
                ]);
                return response()->json([
                    'user' => $user->getInfo(),
                ]);
            }
            $message = empty($charge['id']) ? $charge : '3DSecure transactions';
        }
        return response()->json([
            'message' => $message,
        ], 422);
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
                Rule::exists('plans', 'id')->where(function (Builder $query) use ($user) {
                    return $query->where('id', '<>', $user['plan_id']);
                }),
            ],
        ]);
        if (!General::sendPlanChangeRequestEmail($user, $request['name'])) {
            return response()->json([
                'message' => 'Something went wrong. Please try again later.',
            ], 500);
        }
        return response()->json([
            'status' => 'OK',
        ]);
    }

    public function families(Request $request) {
        $user = $request->user();
        $families = Member::query()
            ->with([
                'profile:member_id,share_age_gender,age,gender,rating,matches,wins,losses',
            ])
            ->where('id', '<>', $user['id'])
            ->where('plan_id', Plan::FamilyPlanId)
            ->where('primary_id', $user['id'])
            ->where('status', '<>', 'inactive')
            ->get([
                'id', 'memberID', 'firstname', 'lastname', 'gender', 'dob', 'avatar', 'is_child'
            ]);
        foreach ($families as $family) {
            General::getGenderAge($family);
        }
        $limit = Setting::getSetting('secondary_limit', Setting::DefaultSecondaryLimit);
        return response()->json([
            'families' => $families,
            'limit' => $limit,
        ]);
    }

    public function inviteMember(Request $request) {
        $request->validate([
            'email' => ['required', 'email', 'unique:members'],
        ]);
        $request['firstname'] = '';
        $request['lastname'] = '';
        $member = General::createInvitedMember($request);
        if (empty($member['id'])) {
            return response()->json(['message' => $member], 400);
        }
        return response()->json([
            'status' => 'OK',
        ]);
    }

    public function addChild(Request $request) {
        $user = $request->user();
        $limit = Setting::getSetting('secondary_limit', Setting::DefaultSecondaryLimit);
        $families = $user->families()->count();
        if ($families >= $limit) {
            return response()->json([
                'message' => 'You have already reached secondary limit.',
            ], 400);
        }
        $request->validate([
            'firstname' => ['required'],
            'lastname' => ['required'],
            'dob' => ['required', 'dateFormat:m/d/Y'],
        ]);
        $request['email'] = 'noreply-'.$user['memberID'].'-'.($families + 1).'@ppbrva.com';
        $member = General::createChildMember($request);
        if (empty($member['id'])) {
            return response()->json(['message' => $member], 400);
        }
        return response()->json([
            'status' => 'OK',
        ]);
    }

    public function familyMember($memberID) {
        $member = Member::query()
            ->with(['profile'])
            ->where('memberID', $memberID)
            ->where('plan_id', Plan::FamilyPlanId)
            ->where('primary_id', auth()->id())
            ->first();
        if (!$member) {
            return response()->json(['message' => 'Member does not exist.'], 404);
        }
        return response()->json([
            'member' => $member->getInfo(),
        ]);
    }

    public function updateFamilyMember(Request $request, $memberID) {
        $member = Member::query()
            ->with(['profile'])
            ->where('memberID', $memberID)
            ->where('plan_id', Plan::FamilyPlanId)
            ->where('primary_id', auth()->id())
            ->first();
        if (!$member) {
            return response()->json(['message' => 'Member does not exist.'], 404);
        }
        $request->validate([
            'avatar' => ['nullable', 'image'],
            'firstname' => ['required'],
            'lastname' => ['required'],
        ]);
        if (!$member['is_child']) {
            $request->validate([
                'email' => ['required', 'email', Rule::unique('members')->ignore($member['id'])],
                'share' => ['required', 'in:true,false'],
            ]);
            if ($request['password'] || $request['password_confirmation']) {
                $request->validate([
                    'password' => ['required', 'confirmed'],
                ]);
            }
        }
        if (!$member['is_child']) {
            if ($member['firstname'] != $request['firstname']
                || $member['lastname'] != $request['lastname']
                || $member['email'] != $request['email']
                || $member['phone'] != $request['phone']
            ) {
                $customer = General::updateCloverCustomer($member, $request);
                if (empty($customer['id'])) {
                    return response()->json(['message' => $customer], 400);
                }
            }
            $member['email'] = $request['email'];
            $member['phone'] = $request['phone'];
            if ($request['password']) {
                $member['password'] = bcrypt($request['password']);
                $member['original_pass'] = null;
            }
        }
        $member['firstname'] = $request['firstname'];
        $member['lastname'] = $request['lastname'];
        if ($request->hasFile('avatar')) {
            General::removeImage($member->getRawOriginal('avatar'));
            $member['avatar'] = 'uploads/'.$request->file('avatar')->store('avatars');
        }
        $member->save();
        if (!$member['is_child']) {
            $profile = $member['profile'];
            $profile['share_age_gender'] = $request['share'] === 'true';
            if ($profile['dupr_id'] != $request['dupr']) {
                General::saveDUPR($profile, $request['dupr']);
            }
            $profile->save();
        }
        return response()->json([
            'member' => $member->getInfo(),
        ]);
    }

    public function removeFamilyMember($memberID) {
        $member = Member::query()
            ->with(['profile'])
            ->where('memberID', $memberID)
            ->where('plan_id', Plan::FamilyPlanId)
            ->where('primary_id', auth()->id())
            ->first();
        if (!$member) {
            return response()->json(['message' => 'Member does not exist.'], 404);
        }
        $member['status'] = 'inactive';
        $member['pause_from'] = null;
        $member['pause_to'] = null;
        $member->save();
        return response()->json([
            'status' => 'OK',
        ]);
    }
}
