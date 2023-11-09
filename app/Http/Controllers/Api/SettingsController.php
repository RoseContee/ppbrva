<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\PlanChangeRequest;
use App\Models\Appicon;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function appicons() {
        return response()->json([
            'appicons' => Appicon::getIcons(),
        ]);
    }

    public function plans() {
        $plans = Plan::get(['id', 'name', 'price']);
        return response()->json([
            'plans' => $plans,
        ]);
    }

    public function planChangeRequest(Request $request) {
        $member = $request->user();
        $request->validate([
            'plan' => [
                'required',
                'exists:plans,id',
                Rule::notIn([$member['plan_id']]),
            ],
        ], [
            'plan.notIn' => 'Please select another plan.',
        ]);
        try {
            $plan = Plan::find($request['plan']);
            Mail::to('info@divstrong.com')->send(new PlanChangeRequest([
                'member' => $member,
                'plan' => $plan['name'],
            ]));
        } catch (\Exception $exception) {
            return response()->json([
                'message' => 'Something went wrong. Please try again later.',
            ], 500);
        }
        return response()->json(null);
    }
}
