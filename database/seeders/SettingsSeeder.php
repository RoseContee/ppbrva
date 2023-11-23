<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'key' => 'shop_link',
            'value' => 'https://app.pingpod.com/',
        ]);
        Setting::create([
            'key' => 'improve_link',
            'value' => 'https://app.pingpod.com/',
        ]);
        Setting::create([
            'key' => 'rent_link',
            'value' => 'https://app.pingpod.com/',
        ]);
        Setting::create([
            'key' => 'shop_link',
            'value' => 'https://ppbrva.com/shop/',
        ]);
        Setting::create([
            'key' => 'dupr_link',
            'value' => 'https://ppbrva.com/dupr',
        ]);
    }
}
