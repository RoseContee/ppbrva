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
            'key' => 'play_icon',
            'value' => null,
        ]);
        Setting::query()->create([
            'key' => 'play_link',
            'value' => 'https://app.pingpod.com/',
        ]);
        Setting::query()->create([
            'key' => 'improve_icon',
            'value' => null,
        ]);
        Setting::query()->create([
            'key' => 'improve_link',
            'value' => 'https://app.pingpod.com/',
        ]);
        Setting::query()->create([
            'key' => 'rent_icon',
            'value' => null,
        ]);
        Setting::query()->create([
            'key' => 'rent_link',
            'value' => 'https://app.pingpod.com/',
        ]);
        Setting::query()->create([
            'key' => 'shop_icon',
            'value' => null,
        ]);
        Setting::query()->create([
            'key' => 'shop_link',
            'value' => 'https://ppbrva.com/shop/',
        ]);
        Setting::query()->create([
            'key' => 'social1_icon',
            'value' => null,
        ]);
        Setting::query()->create([
            'key' => 'social1_link',
            'value' => 'https://twitter.com/PPBRVA/',
        ]);
        Setting::query()->create([
            'key' => 'social2_icon',
            'value' => null,
        ]);
        Setting::query()->create([
            'key' => 'social2_link',
            'value' => 'https://www.youtube.com/@ppbrva/',
        ]);
        Setting::query()->create([
            'key' => 'social3_icon',
            'value' => null,
        ]);
        Setting::query()->create([
            'key' => 'social3_link',
            'value' => 'https://www.instagram.com/ppbrva/',
        ]);
        Setting::query()->create([
            'key' => 'contact_email',
            'value' => 'info@divstrong.com',
        ]);
        Setting::query()->create([
            'key' => 'dupr_link',
            'value' => 'https://ppbrva.com/dupr',
        ]);
        Setting::query()->create([
            'key' => 'secondary_limit',
            'value' => 5,
        ]);
    }
}
