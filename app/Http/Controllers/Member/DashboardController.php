<?php

namespace App\Http\Controllers\Member;

use App\Helpers\General;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Member;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $member = Member::query()
            ->with(['profile', 'plan'])
            ->find(auth()->id());
        return view('member.dashboard', [
            'member' => $member,
            'dashboard' => Setting::getDashboard(),
        ]);
    }
}
