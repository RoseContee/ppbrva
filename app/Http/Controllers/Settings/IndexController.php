<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index() {
        return view('settings.index');
    }

    public function general() {
        $settings = Setting::getSetting([
            'contact_email', 'dupr_link', 'secondary_limit'
        ]);
        return view('settings.general', [
            'settings' => $settings,
        ]);
    }

    public function storeGeneral(Request $request) {
        $request->validate([
            'contact_email' => ['required', 'email'],
            'dupr_link' => ['required', 'url'],
            'secondary_limit' => ['required', 'numeric'],
        ]);
        Setting::saveSetting($request->only([
            'contact_email', 'dupr_link', 'secondary_limit'
        ]));
        return back()->with('success_message', 'Settings have been updated.');
    }

    public function generalContent() {
        $settings = Setting::getSetting(['first_payment']);
        return view('settings.general-content', [
            'settings' => $settings,
        ]);
    }

    public function storeGeneralContent(Request $request) {
        $request->validate([
            'first_payment' => ['required'],
        ]);
        Setting::saveSetting($request->only(['first_payment']));
        return back()->with('success_message', 'Settings have been updated.');
    }
}
