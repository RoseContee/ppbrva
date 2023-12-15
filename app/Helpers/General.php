<?php

namespace App\Helpers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class General
{
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

    public static function createMember(Request $request, string $status) {
        $clover = new Clover();
        $customer = $clover->createCustomer([
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'email' => $request['email'],
            'phone' => $request['phone'],
        ]);
        if (empty($customer['id'])) return $customer;
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
            'membership_card_id' => $request['membership_card_id'],
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
        $member->profile()->updateOrCreate([
            'member_id' => $member['id'],
        ]);
        return $member;
    }

    public static function updateMember($member, Request $request) {
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
            $member->removeAvatar();
            $member['avatar'] = 'uploads/'.$request->file('avatar')->store('avatars');
        }
        return $member;
    }
}
