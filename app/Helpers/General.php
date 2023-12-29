<?php

namespace App\Helpers;

use App\Models\Member;
use App\Models\MemberProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class General
{
    public static int $FamilyPlanId = 8;

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

    public static function createMember(Request $request, string $status) {
        $clover = new Clover();
        $customer = $clover->createCustomer([
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'email' => $request['email'],
            'phone' => $request['phone'],
        ]);
        if (empty($customer['id'])) return $customer;
        $primary_id = $secondary_fee = null;
        if ($request['plan'] == self::$FamilyPlanId) {
            if ($request['family_type'] == 'secondary') {
                $primary_id = $request['primary_account'];
            }
            $secondary_fee = $request['additional_monthly_fee'];
        }
        $password = Str::random(8);
        $member = Member::query()->create([
            'memberID' => Str::random(),
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'email' => $request['email'],
            'password' => bcrypt($password),
            'original_pass' => $password,
            'phone' => $request['phone'],
            'gender' => $request['gender'],
            'dob' => date('Y-m-d', strtotime($request['dob'])),
            'address' => $request['address'],
            'city' => $request['city'],
            'state' => $request['state'],
            'zipcode' => $request['zipcode'],
            'location_id' => $request['location'],
            'plan_id' => $request['plan'],
            'primary_id' => $primary_id,
            'is_child' => null,
            'secondary_fee' => $secondary_fee,
            'membership_card_id' => $request['membership_card_id'],
            'note' => $request['note'],
            'customerID' => $customer['id'],
            'status' => $status,
        ]);
        if ($request->hasFile('avatar')) {
            $member['avatar'] = 'uploads/'.$request->file('avatar')->store('avatars');
        }
        if ($member['id'] < 10000) {
            $member['memberID'] = 'PPB'.str_pad($member['id'], 4, '0', STR_PAD_LEFT);
        } else {
            $member['memberID'] = 'PPB'.$member['id'];
        }
        $member->save();
        $profile = $member['profile'];
        self::saveDUPR($profile, $request['dupr_id']);
        $profile->save();
        return $member;
    }

    public static function updateMember(Member $member, Request $request) {
        if ($member['firstname'] != $request['firstname']
            || $member['lastname'] != $request['lastname']
            || $member['email'] != $request['email']
            || $member['phone'] != $request['phone']
        ) {
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
            }
            if (empty($customer['id'])) return $customer;
            $member['firstname'] = $request['firstname'];
            $member['lastname'] = $request['lastname'];
            $member['email'] = $request['email'];
            $member['phone'] = $request['phone'];
        }
        $member['gender'] = $request['gender'];
        $member['dob'] = date('Y-m-d', strtotime($request['dob']));
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
}
