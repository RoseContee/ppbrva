<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\General;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AppSettingsController extends Controller
{
    public function dashboard() {
        return view('settings.app-dashboard', [
            'settings' => Setting::getDashboard(),
        ]);
    }

    public function storeDashboard(Request $request) {
        $request->validate([
            'play_icon' => ['nullable', 'image'],
            'play_link' => ['required', 'url'],
            'improve_icon' => ['nullable', 'image'],
            'improve_link' => ['required', 'url'],
            'rent_icon' => ['nullable', 'image'],
            'rent_link' => ['required', 'url'],
            'shop_icon' => ['nullable', 'image'],
            'shop_link' => ['required', 'url'],
        ]);
        $old = Setting::getSetting(['play_icon', 'improve_icon', 'rent_icon', 'shop_icon']);
        $settings = $request->only(['play_link', 'improve_link', 'rent_link', 'shop_link']);
        if ($request->hasFile('play_icon')) {
            General::removeImage($old['play_icon']);
            $settings['play_icon'] = 'uploads/'.$request->file('play_icon')->store('appicons');
        }
        if ($request->hasFile('improve_icon')) {
            General::removeImage($old['improve_icon']);
            $settings['improve_icon'] = 'uploads/'.$request->file('improve_icon')->store('appicons');
        }
        if ($request->hasFile('rent_icon')) {
            General::removeImage($old['rent_icon']);
            $settings['rent_icon'] = 'uploads/'.$request->file('rent_icon')->store('appicons');
        }
        if ($request->hasFile('shop_icon')) {
            General::removeImage($old['shop_icon']);
            $settings['shop_icon'] = 'uploads/'.$request->file('shop_icon')->store('appicons');
        }
        Setting::saveSetting($settings);
        return back()->with('info_message', 'App dashboard settings have been updated.');
    }

    public function socialMedia() {
        return view('settings.social-media', [
            'settings' => Setting::getSocialMedia(),
        ]);
    }

    public function storeSocialMedia(Request $request) {
        $request->validate([
            'social1_icon' => ['nullable', 'image'],
            'social1_link' => ['required', 'url'],
            'social2_icon' => ['nullable', 'image'],
            'social2_link' => ['required', 'url'],
            'social3_icon' => ['nullable', 'image'],
            'social3_link' => ['required', 'url'],
        ]);
        $old = Setting::getSetting(['social1_icon', 'social2_icon', 'social2_icon']);
        $settings = $request->only(['social1_link', 'social2_link', 'social3_link']);
        if ($request->hasFile('social1_icon')) {
            General::removeImage($old['social1_icon']);
            $settings['social1_icon'] = 'uploads/'.$request->file('social1_icon')->store('appicons');
        }
        if ($request->hasFile('social2_icon')) {
            General::removeImage($old['social2_icon']);
            $settings['social2_icon'] = 'uploads/'.$request->file('social2_icon')->store('appicons');
        }
        if ($request->hasFile('social3_icon')) {
            General::removeImage($old['social3_icon']);
            $settings['social3_icon'] = 'uploads/'.$request->file('social3_icon')->store('appicons');
        }
        Setting::saveSetting($settings);
        return back()->with('info_message', 'Social media has been updated.');
    }
}
