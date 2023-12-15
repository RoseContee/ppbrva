<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appicon;
use App\Models\KitchenBar;
use App\Models\Plan;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function dashboard() {
        return response()->json([
            'icons' => Appicon::getIcons(),
            'links' => Setting::getSetting([
                'play_link', 'improve_link', 'rent_link', 'shop_link'
            ]),
        ]);
    }

    public function plans() {
        $plans = Plan::query()
            ->where('status', 'public')
            ->get(['id', 'name', 'price']);
        return response()->json([
            'plans' => $plans,
        ]);
    }

    public function kitchenBars() {
        $inventoryItems = KitchenBar::query()
            ->orderBy('sortOrder')
            ->orderBy('category')
            ->get(['itemID', 'category', 'item', 'price']);
        $items = [];
        foreach ($inventoryItems as $item) {
            for ($i = 0; $i < count($items); $i++) {
                if ($items[$i]['category'] == $item['category']) break;
            }
            if ($i === count($items)) {
                $items[] = [
                    'category' => $item['category'],
                    'data' => [],
                ];
            }
            $items[$i]['data'][] = $item;
        }
        return response()->json([
            'items' => $items,
        ]);
    }
}
