<?php

namespace App\Http\Controllers;

use App\Helpers\Clover;
use App\Models\Location;
use App\Models\Member;
use App\Models\Plan;
use App\Notifications\MemberInvite;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    public function index() {
        $members = Member::with(['plan'])->get();
        foreach ($members as $member) {
            if ($member['avatar'] && file_exists(public_path($member['avatar']))) {
                $member['avatar'] = asset($member['avatar']);
            } else {
                $member['avatar'] = asset('img/user-profile.svg');
            }
            $member['plan_name'] = $member['plan']['name'] ?? '';
            $member['original_pass'] = !empty($member['original_pass']);
        }
        return view('members.index', [
            'members' => $members,
        ]);
    }

    public function create() {
        $locations = Location::get();
        $plans = Plan::get();
        return view('members.add', [
            'locations' => $locations,
            'plans' => $plans,
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:members'],
            'location' => ['required', 'exists:locations,id'],
            'plan' => ['required', 'exists:plans,id'],
            'avatar' => ['nullable', 'image'],
        ]);
        $name = $request['name'];
        $email = $request['email'];
        $phone = $request['phone'];

        $clover = new Clover();
        $customer = $clover->createCustomer([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
        ]);
        if (!$customer) {
            return back()->with('error_message', 'Clover API error.');
        }
        $password = Str::random(8);
        $member = Member::create([
            'memberID' => Str::random(),
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($password),
            'original_pass' => $password,
            'phone' => $request['phone'],
            'location_id' => $request['location'],
            'plan_id' => $request['plan'],
            'customer_id' => $customer['id'],
            'active' => !empty($request['status']),
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
        $member->profile()->create([
            'member_id' => $member['id'],
        ]);
        if ($this->notifyInvite($member)) {
            return redirect()->route('members.index')
                ->with('success_message', 'Invitation has been sent.');
        }
        return redirect()->route('members.index')
            ->with('error_message', 'Invitation has not been sent.');
    }

    public function edit($id) {
        $member = Member::find($id);
        if (!$member) return back();
        $locations = Location::get();
        $plans = Plan::get();
        return view('members.add', [
            'member' => $member,
            'locations' => $locations,
            'plans' => $plans,
        ]);
    }

    public function update(Request $request, $id) {
        $member = Member::find($id);
        if (!$member) return back();
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('members')->ignore($member['id'])],
            'location' => ['required', 'exists:locations,id'],
            'plan' => ['required', 'exists:plans,id'],
            'avatar' => ['nullable', 'image'],
        ]);
        $name = $request['name'];
        $email = $request['email'];
        $phone = $request['phone'];

        if ($member['name'] != $name
            || $member['email'] != $email
            || $member['phone'] != $phone
        ) {
            $clover = new Clover();
            $clover->updateCustomer($member['customer_id'], [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
            ]);
        }
        $member['name'] = $name;
        $member['email'] = $email;
        $member['phone'] = $phone;
        $member['location_id'] = $request['location'];
        $member['plan_id'] = $request['plan'];
        if ($request->hasFile('avatar')) {
            if ($member['avatar'] && file_exists(public_path($member['avatar']))) {
                unlink(public_path($member['avatar']));
            }
            $member['avatar'] = 'uploads/'.$request->file('avatar')->store('avatars');
        }
        $member['active'] = !empty($request['status']);
        $member->save();
        return back()->with('info_message', 'Member has been updated.');
    }

    public function destroy(Request $request) {
        $members = explode(',', $request['members']);
        Member::whereIn('id', $members)->delete();
        return back()->with('error_message', 'Members has been removed.');
    }

    public function sendInvite(Request $request) {
        if (!($member = Member::find($request['member']))) {
            return back()->with('error_message', 'Member does not exist.');
        }
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
                'password' => $member['original_pass'],
            ]));
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }
}
