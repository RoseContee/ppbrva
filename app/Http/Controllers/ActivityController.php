<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Category;
use App\Models\Member;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index() {
        $activities = Activity::with(['member'])
            ->orderBy('date', 'desc')
            ->get();
        return view('activity.index', [
            'activities' => $activities,
        ]);
    }

    public function create() {
        $members = Member::get();
        $categories = Category::get();
        return view('activity.add', [
            'members' => $members,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'member' => ['required', 'exists:members,id'],
            'category' => ['required', 'exists:categories,name'],
            'detail' => ['required'],
            'amount' => ['required', 'numeric'],
            'date' => ['required', 'date_format:m/d/Y'],
        ]);
        Activity::create([
            'member_id' => $request['member'],
            'category' => $request['category'],
            'detail' => $request['detail'],
            'price' => $request['amount'],
            'date' => date('Y-m-d', strtotime($request['date'])),
            'from' => 'admin',
        ]);
        return redirect()->route('activity.index')
            ->with('success_message', 'New activity has been added.');
    }

    public function edit($id) {
        $activity = Activity::where('id', $id)
            ->where('from', 'admin')
            ->whereNull('invoice_id')
            ->first();
        if (!$activity) return back();
        $members = Member::get();
        $categories = Category::get();
        return view('activity.add', [
            'members' => $members,
            'categories' => $categories,
            'activity' => $activity,
        ]);
    }

    public function update(Request $request, $id) {
        $activity = Activity::where('id', $id)
            ->where('from', 'admin')
            ->whereNull('invoice_id')
            ->first();
        if (!$activity) return back();
        $request->validate([
            'member' => ['required', 'exists:members,id'],
            'category' => ['required', 'exists:categories,name'],
            'detail' => ['required'],
            'amount' => ['required', 'numeric'],
            'date' => ['required', 'date_format:m/d/Y'],
        ]);
        $activity['member_id'] = $request['member'];
        $activity['category'] = $request['category'];
        $activity['detail'] = $request['detail'];
        $activity['price'] = $request['amount'];
        $activity['date'] = date('Y-m-d', strtotime($request['date']));
        $activity['from'] = 'admin';
        $activity->save();
        return back()->with('info_message', 'Activity has been updated.');
    }

    public function destroy(Request $request) {
        Activity::whereIn('id', explode(',', $request['activities']))
            ->where('from', 'admin')
            ->whereNotNull('invoice_id')
            ->delete();
        return back()->with('error_message', 'Activities have been removed.');
    }
}
