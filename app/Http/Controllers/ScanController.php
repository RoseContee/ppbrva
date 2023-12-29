<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function index() {
        return view('scan');
    }

    public function store(Request $request) {
        $member = Member::query()
            ->whereNotNull('membership_card_id')
            ->where('membership_card_id', $request['card_id'])
            ->first();
        return view('scan', [
            'member' => $member ?? null,
            'error' => 'member not found',
        ]);
    }
}
