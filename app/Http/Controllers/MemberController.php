<?php

namespace App\Http\Controllers;

use App\Helpers\General;
use App\Mail\NewMemberCreated;
use App\Models\Location;
use App\Models\Member;
use App\Models\Plan;
use App\Models\Setting;
use App\Notifications\MemberInvite;
use App\Rules\State as StateRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
            'phone' => ['required'],
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
        try {
            $contact_email = Setting::getSetting('contact_email', 'info@divstrong.com');
            $plan = Plan::query()->find($request['plan']);
            Mail::to($contact_email)->send(new NewMemberCreated([
                'plan' => $plan['name'],
                'member' => $member,
            ]));
        } catch (\Exception $exception) {}
        session(['new_member' => $member['memberID']]);
        return redirect()->route('members.thanks');
    }

    public function thanks() {
        if (!session('new_member')) {
            return redirect()->route('members.join');
        }
        session()->forget('new_member');
        return view('members.thanks');
    }

    public function index() {
        $members = Member::query()->with(['plan'])->get();
        return view('members.index', [
            'members' => $members,
        ]);
    }

    public function create() {
        $states = General::getStates();
        $locations = Location::query()->get();
        $plans = Plan::query()->get();
        return view('members.add', [
            'states' => $states,
            'locations' => $locations,
            'plans' => $plans,
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'firstname' => ['required'],
            'lastname' => ['required'],
            'gender' => ['required', 'in:male,female,prefer_not_to_say'],
            'email' => ['required', 'email', 'unique:members'],
            'dob' => ['required', 'dateFormat:m/d/Y'],
            'address' => ['required'],
            'city' => ['required'],
            'state' => ['required', new StateRule],
            'zipcode' => ['required'],
            'location' => ['required', 'exists:locations,id'],
            'plan' => ['required', 'exists:plans,id'],
            'avatar' => ['nullable', 'image'],
        ]);
        $member = General::createMember($request, 'active');
        if (empty($member['id'])) {
            return back()->withInput()->with('error_message', $member);
        }
        if ($this->notifyInvite($member)) {
            return redirect()->route('members.index')
                ->with('success_message', 'Invitation has been sent.');
        }
        return redirect()->route('members.index')
            ->with('error_message', 'Invitation has not been sent.');
    }

    public function edit($id) {
        $member = Member::query()->find($id);
        if (!$member) return back();
        $states = General::getStates();
        $locations = Location::get();
        $plans = Plan::get();
        return view('members.add', [
            'member' => $member,
            'states' => $states,
            'locations' => $locations,
            'plans' => $plans,
        ]);
    }

    public function update(Request $request, $id) {
        $member = Member::query()->find($id);
        if (!$member) return back();
        $request->validate([
            'firstname' => ['required'],
            'lastname' => ['required'],
            'gender' => ['required', 'in:male,female,prefer_not_to_say'],
            'email' => ['required', 'email', Rule::unique('members')->ignore($member['id'])],
            'dob' => ['required', 'dateFormat:m/d/Y'],
            'address' => ['required'],
            'city' => ['required'],
            'state' => ['required', new StateRule],
            'zipcode' => ['required'],
            'location' => ['required', 'exists:locations,id'],
            'plan' => ['required', 'exists:plans,id'],
            'avatar' => ['nullable', 'image'],
        ]);
        if ($member['status'] != 'pending') {
            $request->validate([
                'status' => ['required', 'in:active,inactive,paused'],
                'pause_from' => ['required_if:status,paused', 'dateFormat:m/d/Y'],
                'pause_to' => ['required_if:status,paused', 'dateFormat:m/d/Y'],
            ]);
        }
        $member = General::updateMember($member, $request);
        if (empty($member['id'])) {
            return back()->withInput()->with('error_message', $member);
        }
        $member['location_id'] = $request['location'];
        $member['plan_id'] = $request['plan'];
        $member['membership_card_id'] = $request['membership_card_id'];
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
        $member->profile()->updateOrCreate([
            'member_id' => $member['id'],
        ]);
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
            return redirect()->route('members.index')
                ->with('success_message', 'Invitation has been sent.');
        }
        return redirect()->route('members.index')
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
            return redirect()->route('members.index')
                ->with('success_message', 'Invitation has been sent.');
        }
        return redirect()->route('members.index')
            ->with('error_message', 'Invitation has not been sent.');
    }

    protected function notifyInvite($member) {
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
