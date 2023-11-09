<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Appicon;
use Illuminate\Http\Request;

class AppiconsController extends Controller
{
    public function index() {
        return view('settings.appicons.index', [
            'appicons' => Appicon::getIcons()
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'play_icon' => ['nullable', 'image'],
            'improve_icon' => ['nullable', 'image'],
            'rent_icon' => ['nullable', 'image'],
            'shop_icon' => ['nullable', 'image'],
        ]);
        if ($request->hasFile('play_icon')) {
            $appicon = Appicon::firstOrNew(['id' => Appicon::$play]);
            $appicon->removeIcon();
            $appicon['icon'] = 'uploads/'.$request->file('play_icon')->store('appicons');
            $appicon->save();
        }
        if ($request->hasFile('improve_icon')) {
            $appicon = Appicon::firstOrNew(['id' => Appicon::$improve]);
            $appicon->removeIcon();
            $appicon['icon'] = 'uploads/'.$request->file('improve_icon')->store('appicons');
            $appicon->save();
        }
        if ($request->hasFile('rent_icon')) {
            $appicon = Appicon::firstOrNew(['id' => Appicon::$rent]);
            $appicon->removeIcon();
            $appicon['icon'] = 'uploads/'.$request->file('rent_icon')->store('appicons');
            $appicon->save();
        }
        if ($request->hasFile('shop_icon')) {
            $appicon = Appicon::firstOrNew(['id' => Appicon::$shop]);
            $appicon->removeIcon();
            $appicon['icon'] = 'uploads/'.$request->file('shop_icon')->store('appicons');
            $appicon->save();
        }
        return back()->with('info_message', 'App icons have been updated.');
    }
}
