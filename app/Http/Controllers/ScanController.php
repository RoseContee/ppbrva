<?php

namespace App\Http\Controllers;

use App\Models\Member;
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
        return view('scan.cardid', [
            'member' => $member ?? null,
            'error' => 'member not found',
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
