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
        Setting::query()->create([
            'key' => 'contact_email',
            'value' => 'info@divstrong.com',
        ]);
        Setting::query()->create([
            'key' => 'shop_link',
            'value' => 'https://app.pingpod.com/',
        ]);
        Setting::query()->create([
            'key' => 'improve_link',
            'value' => 'https://app.pingpod.com/',
        ]);
        Setting::query()->create([
            'key' => 'rent_link',
            'value' => 'https://app.pingpod.com/',
        ]);
        Setting::query()->create([
            'key' => 'shop_link',
            'value' => 'https://ppbrva.com/shop/',
        ]);
        Setting::query()->create([
            'key' => 'dupr_link',
            'value' => 'https://ppbrva.com/dupr',
        ]);
    }
}
