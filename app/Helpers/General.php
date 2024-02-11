<?php

namespace App\Helpers;

use App\Http\Controllers\Api\PodPlayController;
use App\Mail\NewMemberCreated;
use App\Mail\PlanChangeRequest;
use App\Models\Member;
use App\Models\MemberProfile;
use App\Models\Plan;
use App\Models\Setting;
use App\Notifications\MemberResetCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class General
{
    public static int $reset_code_expiration = 60;

    public static array $colors = [
        '#4bc0c0', '#36a2eb', '#ff6384', '#ff9f40', '#ffcd56',
        '#9966ff', '#0358b6', '#44de28', '#d60000', '#c9cbcf',
    ];

    public static function removeImage(string $image = null) {
        $image = public_path($image);
        if (is_file($image)) unlink($image);
    }

    public static function getStates() {
        return [
            'AL' => 'Alabama',
            'AK' => 'Alaska',
            'AZ' => 'Arizona',
            'AR' => 'Arkansas',
            'CA' => 'California',
            'CO' => 'Colorado',
            'CT' => 'Connecticut',
            'DE' => 'Delaware',
            'DC' => 'District Of Columbia',
            'FL' => 'Florida',
            'GA' => 'Georgia',
            'HI' => 'Hawaii',
            'ID' => 'Idaho',
            'IL' => 'Illinois',
            'IN' => 'Indiana',
            'IA' => 'Iowa',
            'KS' => 'Kansas',
            'KY' => 'Kentucky',
            'LA' => 'Louisiana',
            'ME' => 'Maine',
            'MD' => 'Maryland',
            'MA' => 'Massachusetts',
            'MI' => 'Michigan',
            'MN' => 'Minnesota',
            'MS' => 'Mississippi',
            'MO' => 'Missouri',
            'MT' => 'Montana',
            'NE' => 'Nebraska',
            'NV' => 'Nevada',
            'NH' => 'New Hampshire',
            'NJ' => 'New Jersey',
            'NM' => 'New Mexico',
            'NY' => 'New York',
            'NC' => 'North Carolina',
            'ND' => 'North Dakota',
            'OH' => 'Ohio',
            'OK' => 'Oklahoma',
            'OR' => 'Oregon',
            'PA' => 'Pennsylvania',
            'RI' => 'Rhode Island',
            'SC' => 'South Carolina',
            'SD' => 'South Dakota',
            'TN' => 'Tennessee',
            'TX' => 'Texas',
            'UT' => 'Utah',
            'VT' => 'Vermont',
            'VA' => 'Virginia',
            'WA' => 'Washington',
            'WV' => 'West Virginia',
            'WI' => 'Wisconsin',
            'WY' => 'Wyoming',
        ];
    }

    public static function generateMemberID($id) {
        if ($id >= 10000) return 'PPB'.$id;
        return 'PPB'.str_pad($id, 4, '0', STR_PAD_LEFT);
    }

    public static function saveDUPR(MemberProfile $profile, string|null $duprId) {
        $dupr = new Dupr();
        $duprInfo = $dupr->getPlayInfo($duprId);
        $profile['dupr_id'] = $duprId;
        $profile['gender'] = $duprInfo['gender'] ?? null;
        $profile['age'] = $duprInfo['age'] ?? null;
        $profile['rating'] = $duprInfo['rating'] ?? null;
        $profile['matches'] = $duprInfo['matches'] ?? null;
        $profile['wins'] = $duprInfo['wins'] ?? null;
        $profile['losses'] = $duprInfo['losses'] ?? null;
    }

    public static function updateCloverCustomer(Member $member, Request $request) {
        $clover = new Clover();
        $customer = $clover->getCustomer($member['customerID']);
        if (!empty($customer['id'])) {
            $customer = $clover->updateCustomer($member['customerID'], [
                'firstname' => $request['firstname'],
                'lastname' => $request['lastname'],
                'email' => [
                    'id' => $customer['emailAddresses']['elements'][0]['id'] ?? '',
                    'value' => $request['email'],
                ],
                'phone' => [
                    'id' => $customer['phoneNumbers']['elements'][0]['id'] ?? '',
                    'value' => $request['phone'],
                ],
            ]);
            /*
            } else {
                $customer = $clover->createCustomer([
                    'firstname' => $request['firstname'],
                    'lastname' => $request['lastname'],
                    'email' => $request['email'],
                    'phone' => $request['phone'],
                ]);
            */
            if (!empty($customer['id'])) {
                $clover->updateCustomerLastname($member['customerID'], "{$request['lastname']}-{$member['id']}");
            }
        }
        return $customer;
    }

    public static function createMember(Request $request, string $status) {
        $clover = new Clover();
        $customer = $clover->createCustomer([
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'email' => $request['email'],
            'phone' => $request['phone'],
        ]);
        if (empty($customer['id'])) return $customer;
        $primary_id = $is_child = $secondary_fee = null;
        if ($request['plan'] == Plan::FamilyPlanId
            && $request['family_type'] == 'secondary'
        ) {
            $primary_id = $request['primary_account'];
            $is_child = $request['is_child'];
            $secondary_fee = $request['additional_monthly_fee'];
        }
        $password = Str::random(8);
        if ($dob = $request['dob']) {
            $dob = date('Y-m-d', strtotime($dob));
        }
        $member = Member::query()->create([
            'memberID' => Str::random(),
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'email' => $request['email'],
            'password' => bcrypt($password),
            'original_pass' => $password,
            'phone' => $request['phone'],
            'gender' => $request['gender'],
            'dob' => $dob,
            'address' => $request['address'],
            'city' => $request['city'],
            'state' => $request['state'],
            'zipcode' => $request['zipcode'],
            'location_id' => $request['location'],
            'plan_id' => $request['plan'],
            'primary_id' => $primary_id,
            'is_child' => $is_child,
            'secondary_fee' => $secondary_fee,
            'membership_card_id' => $request['membership_card_id'],
            'note' => $request['note'],
            'customerID' => $customer['id'],
            'status' => $status,
            'podplay_id' => (new PodPlayController())->podplaynew($request),
        ]);
        if ($request->hasFile('avatar')) {
            $member['avatar'] = 'uploads/'.$request->file('avatar')->store('avatars');
        }
        $member['memberID'] = self::generateMemberID($member['id']);
        $member->save();
        $profile = $member['profile'];
        self::saveDUPR($profile, $request['dupr_id']);
        $profile->save();
        $clover->updateCustomerLastname($member['customerID'], "{$request['lastname']}-{$member['id']}");
        return $member;
    }

    public static function createInvitedMember(Request $request) {
        $clover = new Clover();
        $customer = $clover->createCustomer([
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'email' => $request['email'],
        ]);
        if (empty($customer['id'])) return $customer;
        $user = $request->user();
        $password = Str::random(8);
        $member = Member::query()->create([
            'memberID' => Str::random(),
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'email' => $request['email'],
            'password' => bcrypt($password),
            'original_pass' => $password,
            'location_id' => $user['location_id'],
            'plan_id' => $user['plan_id'],
            'customerID' => $customer['id'],
            'status' => 'pending',
            'podplay_id' => (new PodPlayController())->podplaynew($request),
        ]);
        $member['memberID'] = self::generateMemberID($member['id']);
        $member->save();
        $member['profile']->save();
        $clover->updateCustomerLastname($member['customerID'], "-{$member['id']}");
        self::sendNewMemberCreatedEmail($member);
        return $member;
    }

    public static function createChildMember(Request $request) {
        $clover = new Clover();
        $customer = $clover->createCustomer([
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'email' => $request['email'],
        ]);
        if (empty($customer['id'])) return $customer;
        $user = $request->user();
        $member = Member::query()->create([
            'memberID' => Str::random(),
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'email' => $request['email'],
            'password' => Str::random(),
            'dob' => date('Y-m-d', strtotime($request['dob'])),
            'location_id' => $user['location_id'],
            'plan_id' => $user['plan_id'],
            'primary_id' => $user['id'],
            'is_child' => true,
            'customerID' => $customer['id'],
            'status' => 'active',
            'podplay_id' => (new PodPlayController())->podplaynew($request),
        ]);
        $member['memberID'] = self::generateMemberID($member['id']);
        $member->save();
        $member['profile']->save();
        $clover->updateCustomerLastname($member['customerID'], "{$request['lastname']}-{$member['id']}");
        self::sendNewMemberCreatedEmail($member);
        return $member;
    }

    public static function updateMember(Member $member, Request $request) {
        if ($member['firstname'] != $request['firstname']
            || $member['lastname'] != $request['lastname']
            || $member['email'] != $request['email']
            || $member['phone'] != $request['phone']
        ) {
            $customer = self::updateCloverCustomer($member, $request);
            if (empty($customer['id'])) return $customer;
        }
        $member['firstname'] = $request['firstname'];
        $member['lastname'] = $request['lastname'];
        $member['email'] = $request['email'];
        $member['phone'] = $request['phone'];
        $member['gender'] = $request['gender'];
        if ($dob = $request['dob']) {
            $dob = date('Y-m-d', strtotime($dob));
        }
        $member['dob'] = $dob;
        $member['address'] = $request['address'];
        $member['city'] = $request['city'];
        $member['state'] = $request['state'];
        $member['zipcode'] = $request['zipcode'];
        if ($request->hasFile('avatar')) {
            self::removeImage($member->getRawOriginal('avatar'));
            $member['avatar'] = 'uploads/'.$request->file('avatar')->store('avatars');
        }
        return $member;
    }

    public static function getGenderAge($member) {
        $profile = $member['profile'];
        $gender = $member['gender'] ?: $profile['gender'];
        if (!$gender || $gender == 'prefer_not_to_say') $gender = '';
        if (!$member['dob']) $age = $profile['age'];
        else $age = Carbon::parse($member['dob'])->age;
        $profile['gender'] = $gender;
        $profile['age'] = $age;
    }

    public static function sendNewMemberCreatedEmail($member) {
        try {
            $default = Setting::DefaultContactEmail;
            $contact_email = Setting::getSetting('contact_email', $default);
            Mail::to($contact_email)->send(new NewMemberCreated([
                'member' => $member,
            ]));
        } catch (\Exception $exception) {}
    }

    public static function sendPlanChangeRequestEmail($member, $newPlan) {
        try {
            $default = Setting::DefaultContactEmail;
            $plan = Plan::query()->find($newPlan);
            $contact_email = Setting::getSetting('contact_email', $default);
            Mail::to($contact_email)->send(new PlanChangeRequest([
                'plan' => $plan['name'] ?? 'Unknown',
                'member' => $member,
            ]));
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    /**
     * @throws ValidationException
     */
    public static function memberForgotPassword(Request $request) {
        $request->validate([
            'email' => ['required', 'email'],
        ]);
        $user = Member::query()
            ->where('email', $request['email'])
            ->whereIn('status', ['active', 'paused', 'suspended'])
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
            $code_expiration = General::$reset_code_expiration;
            $expiration = date('Y-m-d H:i:s', strtotime("-{$code_expiration} minutes"));
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
                'expiration' => $code_expiration,
            ]));
        } catch (\Exception $exception) {
            throw ValidationException::withMessages([
                'email' => [$exception->getMessage()],
            ]);
        }
    }

    /**
     * @throws ValidationException
     */
    public static function memberResetPassword(Request $request) {
        $code_expiration = General::$reset_code_expiration;
        $expiration = date('Y-m-d H:i:s', strtotime("-{$code_expiration} minutes"));
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
            ->whereIn('status', ['active', 'paused', 'suspended'])
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
    }
}
