<?php

namespace App\Http\Controllers\Member;

use App\Helpers\General;
use App\Http\Controllers\Controller;
use App\Rules\Phone as PhoneRule;
use App\Rules\State as StateRule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index() {
        $states = General::getStates();
        return view('member.profile', [
            'states' => $states,
        ]);
    }

    public function member() {
    }

    public function saveMember(Request $request) {
        $member = auth('member')->user();
        $request->validate([
            'firstname' => ['required'],
            'lastname' => ['required'],
            'gender' => ['nullable', 'in:male,female,prefer_not_to_say'],
            'email' => ['required', 'email', Rule::unique('members')->ignore($member['id'])],
            'phone' => ['nullable', new PhoneRule],
            'dob' => ['nullable', 'dateFormat:m/d/Y'],
            'state' => ['nullable', new StateRule],
            'avatar' => ['nullable', 'image'],
        ]);
        $member = General::updateMember($member, $request);
        if (empty($member['id'])) {
            return back()->withInput()->with('error_message', $member);
        }
        $member->save();
        $profile = $member['profile'];
        if ($profile['dupr_id'] != $request['dupr_id']) {
            General::saveDUPR($profile, $request['dupr_id']);
            $profile->save();
        }
        return back()->with('info_message', 'Profile has been updated.');
    }

    public function billing() {
    }

    public function saveBilling(Request $request) {
    }

    public function membershipPlan() {
    }

    public function saveMembershipPlan(Request $request) {
    }
}
