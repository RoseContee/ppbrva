<?php

namespace App\Http\Controllers;

use App\Helpers\General;
use App\Models\Location;
use App\Models\Member;
use App\Models\Plan;
use App\Models\Setting;
use App\Notifications\MemberInvite;
use App\Rules\Family as FamilyRule;
use App\Rules\Phone as PhoneRule;
use App\Rules\State as StateRule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    public function joinForm() {
        $plans = Plan::query()
            ->where('status', 'public')
            ->get();
        $states = General::getStates();
        $locations = Location::query()
            ->get();
        return view('members.join', [
            'plans' => $plans,
            'states' => $states,
            'locations' => $locations,
        ]);
    }

    public function join(Request $request) {
        $request->validate([
            'plan' => ['required', 'exists:plans,id'],
            'firstname' => ['required'],
            'lastname' => ['required'],
            'gender' => ['required', 'in:male,female,prefer_not_to_say'],
            'email' => ['required', 'unique:members,email'],
            'phone' => ['required', new PhoneRule],
            'dob' => ['required', 'dateFormat:m/d/Y'],
            'address' => ['required'],
            'city' => ['required'],
            'state' => ['required', new StateRule],
            'zipcode' => ['required'],
            'location' => ['required', 'exists:locations,id'],
            'agree' => ['required'],
        ]);
        $member = General::createMember($request, 'pending');
        if (empty($member['id'])) {
            return back()->withInput()->with('error_message', $member);
        }
        General::sendNewMemberCreatedEmail($member);
        session(['new_member' => $member['memberID']]);
        return to_route('members.thanks');
    }

    public function thanks() {
        if (!session('new_member')) {
            return to_route('members.join');
        }
        session()->forget('new_member');
        return view('members.thanks');
    }

    public function index() {
        $plans = Plan::query()->get(['id', 'name']);
        $members = Member::query()
            ->with([
                'plan' => function ($query) {
                    $query->select(['id', 'name']);
                }
            ])
            ->get([
                'id', 'avatar', 'memberID', 'firstname', 'lastname',
                'email', 'phone', 'plan_id', 'card_last4', 'status',
            ]);
        return view('members.index', [
            'plans' => $plans,
            'members' => $members,
        ]);
    }

    public function create() {
        $states = General::getStates();
        $locations = Location::query()->get();
        $plans = Plan::query()->get();
        $secondary_limit = Setting::getSetting('secondary_limit', Setting::DefaultSecondaryLimit);
        $primary_members = Member::query()
            ->has('families', '<', $secondary_limit)
            ->where('plan_id', Plan::FamilyPlanId)
            ->whereNull('primary_id')
            ->get();
        return view('members.add', [
            'states' => $states,
            'locations' => $locations,
            'plans' => $plans,
            'family_plan_id' => Plan::FamilyPlanId,
            'primary_members' => $primary_members,
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'firstname' => ['required'],
            'lastname' => ['required'],
            'gender' => ['nullable', 'in:male,female,prefer_not_to_say'],
            'email' => ['required', 'email', 'unique:members'],
            'phone' => ['nullable', new PhoneRule],
            'dob' => ['nullable', 'dateFormat:m/d/Y'],
            'state' => ['nullable', new StateRule],
            'location' => ['required', 'exists:locations,id'],
            'plan' => ['required', 'exists:plans,id'],
            'family_type' => ['nullable', 'required_if:plan,8', 'in:primary,secondary'],
            'primary_account' => ['nullable', new FamilyRule],
            'additional_monthly_fee' => ['nullable', 'numeric'],
            'avatar' => ['nullable', 'image'],
        ], [
            'family_type.required_if' => 'The family type field is required when family plan is selected.',
        ]);
        $member = General::createMember($request, 'active');
        if (empty($member['id'])) {
            return back()->withInput()->with('error_message', $member);
        }
        if ($this->notifyInvite($member)) {
            return to_route('members.index')
                ->with('success_message', 'Invitation has been sent.');
        }
        return to_route('members.index')
            ->with('error_message', 'Invitation has not been sent.');
    }

    public function edit($id) {
        $member = Member::query()->find($id);
        if (!$member) return back();
        $states = General::getStates();
        $locations = Location::query()->get();
        $plans = Plan::query()->get();
        $secondary_limit = Setting::getSetting('secondary_limit', Setting::DefaultSecondaryLimit);
        $primary_members = Member::query()
            ->whereHas('families', function (Builder $query) use ($id) {
                $query->where('id', '<>', $id);
            }, '<', $secondary_limit)
            ->where('id', '<>', $id)
            ->where('plan_id', Plan::FamilyPlanId)
            ->whereNull('primary_id')
            ->get();
        return view('members.add', [
            'member' => $member,
            'states' => $states,
            'locations' => $locations,
            'plans' => $plans,
            'family_plan_id' => Plan::FamilyPlanId,
            'primary_members' => $primary_members,
        ]);
    }

    public function update(Request $request, $id) {
        $member = Member::query()
            ->with(['profile'])
            ->find($id);
        if (!$member) return back();
        $request->validate([
            'firstname' => ['required'],
            'lastname' => ['required'],
            'gender' => ['nullable', 'in:male,female,prefer_not_to_say'],
            'email' => ['required', 'email', Rule::unique('members')->ignore($member['id'])],
            'phone' => ['nullable', new PhoneRule],
            'dob' => ['nullable', 'dateFormat:m/d/Y'],
            'state' => ['nullable', new StateRule],
            'location' => ['required', 'exists:locations,id'],
            'plan' => ['required', 'exists:plans,id'],
            'family_type' => ['nullable', 'required_if:plan,8', 'in:primary,secondary'],
            'primary_account' => ['nullable', new FamilyRule($member['id'])],
            'additional_monthly_fee' => ['nullable', 'numeric'],
            'avatar' => ['nullable', 'image'],
        ], [
            'family_type.required_if' => 'The family type field is required when family plan is selected.',
        ]);
        if ($member['status'] != 'pending') {
            $request->validate([
                'status' => ['required', 'in:active,paused,suspended,inactive'],
                'pause_from' => ['nullable', 'required_if:status,paused', 'dateFormat:m/d/Y', 'before:pause_to'],
                'pause_to' => ['nullable', 'required_if:status,paused', 'dateFormat:m/d/Y', 'after:pause_from'],
            ]);
        }
        $member = General::updateMember($member, $request);
        if (empty($member['id'])) {
            return back()->withInput()->with('error_message', $member);
        }
        $member['location_id'] = $request['location'];
        $member['plan_id'] = $request['plan'];
        $member['primary_id'] = null;
        $member['is_child'] = null;
        $member['secondary_fee'] = null;
        if ($request['plan'] == Plan::FamilyPlanId && $request['family_type'] == 'secondary') {
            $member['primary_id'] = $request['primary_account'];
            $member['is_child'] = $request['is_child'];
            $member['secondary_fee'] = $request['additional_monthly_fee'];
        }
        $member['membership_card_id'] = $request['membership_card_id'];
        $member['note'] = $request['note'];
        if ($member['status'] !== 'pending') {
            $member['status'] = $request['status'];
            $member['pause_from'] = null;
            $member['pause_to'] = null;
            if ($member['status'] === 'paused') {
                $member['pause_from'] = date('Y-m-d', strtotime($request['pause_from']));
                $member['pause_to'] = date('Y-m-d', strtotime($request['pause_to']));
            }
        }
        $member->save();
        $profile = $member['profile'];
        if ($profile['dupr_id'] != $request['dupr_id']) {
            General::saveDUPR($profile, $request['dupr_id']);
            $profile->save();
        }
        return back()->with('info_message', 'Member has been updated.');
    }

    public function destroy(Request $request) {
        $members = explode(',', $request['members']);
        Member::query()->whereIn('id', $members)->delete();
        return back()->with('error_message', 'Members have been removed.');
    }

    public function sendInvite(Request $request) {
        $member = Member::query()
            ->whereNotNull('original_pass')
            ->where('status', 'active')
            ->find($request['member']);
        if (!$member) {
            return back()->with('error_message', 'Member does not exist.');
        }
        if ($this->notifyInvite($member)) {
            return to_route('members.index')
                ->with('success_message', 'Invitation has been sent.');
        }
        return to_route('members.index')
            ->with('error_message', 'Invitation has not been sent.');
    }

    public function approve(Request $request) {
        $member = Member::query()
            ->where('status', 'pending')
            ->find($request['member']);
        if (!$member) {
            return back()->with('error_message', 'Member does not exist.');
        }
        $member['status'] = 'active';
        $member->save();
        if ($this->notifyInvite($member)) {
            return to_route('members.index')
                ->with('success_message', 'Invitation has been sent.');
        }
        return to_route('members.index')
            ->with('error_message', 'Invitation has not been sent.');
    }

    protected function notifyInvite(Member $member) {
        try {
            $member->notify(new MemberInvite([
                'name' => $member['name'],
                'email' => $member['email'],
                'password' => $member->getRawOriginal('original_pass'),
            ]));
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }
}
