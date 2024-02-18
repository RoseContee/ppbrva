<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Member;
use App\Models\Scan;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function index() {
        return view('scan.cardid');
    }

    public function store(Request $request) {
        $member = Member::query()
            ->whereNotNull('membership_card_id')
            ->where('membership_card_id', $request['card_id'])
            ->first();
        if ($member) {
            Scan::query()->create([
                'member_id' => $member['id'],
                'location_id' => $member['location_id'],
            ]);
        }
        return view('scan.cardid', [
            'member' => $member ?? null,
            'error' => 'member not found',
        ]);
    }

    public function history() {
        $scans = Scan::query()
            ->with([
                'member:id,memberID,firstname,lastname,avatar',
                'location:id,name'
            ])
            ->has('member')
            ->get(['id', 'member_id', 'location_id', 'created_at']);
        $locations = Location::query()->get();
        return view('scan.history', [
            'scans' => $scans,
            'locations' => $locations,
        ]);
    }

    public function missingcc() {
        $members = Member::query()
            ->with(['plan'])
            ->whereNull('card_last4')
            ->orWhere('card_last4', '=', '')
            ->get();
        return view('scan.missingcc', [
            'members' => $members,
        ]);
    }
}
