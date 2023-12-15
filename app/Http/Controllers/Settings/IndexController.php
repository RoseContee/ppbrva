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
        $settings = Setting::getSetting();
        return view('settings.general', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request) {
        $request->validate([
            'contact_email' => ['required', 'email'],
            'play_link' => ['required', 'url'],
            'improve_link' => ['required', 'url'],
            'rent_link' => ['required', 'url'],
            'shop_link' => ['required', 'url'],
            'dupr_link' => ['required', 'url'],
        ]);
        Setting::saveSetting($request->only([
            'contact_email',
            'play_link', 'improve_link', 'rent_link', 'shop_link',
            'dupr_link',
        ]));
        return back()->with('success_message', 'Settings have been updated.');
    }
}
