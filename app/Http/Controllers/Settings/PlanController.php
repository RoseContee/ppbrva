<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index() {
        $plans = Plan::query()->with(['members'])->get();
        return view('settings.plans.index', [
            'plans' => $plans,
        ]);
    }

    public function create() {
        return view('settings.plans.add');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => ['required'],
            'price' => ['required', 'numeric'],
            'frequency' => ['required', 'in:monthly'],
            'status' => ['required', 'in:public,private'],
        ]);
        Plan::query()->create([
            'name' => $request['name'],
            'price' => $request['price'],
            'period' => $request['frequency'],
            'status' => $request['status'],
        ]);
        return redirect()->route('settings.plans.index')
            ->with('success_message', 'New membership plan has been added.');
    }

    public function edit($id) {
        $plan = Plan::query()->find($id);
        if (!$plan) return back();
        return view('settings.plans.add', [
            'plan' => $plan,
        ]);
    }

    public function update(Request $request, $id) {
        $plan = Plan::query()->find($id);
        if (!$plan) return back();
        $request->validate([
            'name' => ['required'],
            'price' => ['required', 'numeric'],
            'frequency' => ['required', 'in:monthly'],
            'status' => ['required', 'in:public,private'],
        ]);
        $plan['name'] = $request['name'];
        $plan['price'] = $request['price'];
        $plan['period'] = $request['frequency'];
        $plan['status'] = $request['status'];
        $plan->save();
        return back()->with('info_message', 'Membership plan has been updated.');
    }

    public function destroy(Request $request) {
        $plans = explode(',', $request['plans']);
        Plan::query()->doesntHave('members')->whereIn('id', $plans)->delete();
        return back()->with('error_message', 'Plans have been removed.');
    }
}
