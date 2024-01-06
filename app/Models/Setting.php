<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    public const DefaultContactEmail = 'info@ppbrva.com';
    public const DefaultDuprLink = 'https://ppbrva.com/dupr';
    public const DefaultSecondaryLimit = 5;

    protected $fillable = [
        'key', 'value',
    ];

    public static function getSetting(string|array $keys = null, string|array $default = null): array|string|null
    {
        $setting = [];
        switch (gettype($keys)) {
            case 'string':
                $item = self::query()
                    ->where('key', $keys)
                    ->first();
                $setting = $item['value'] ?? $default;
                break;
            case 'array':
                $settings = self::query()
                    ->whereIn('key', $keys)
                    ->pluck('value', 'key');
                foreach ($keys as $key) {
                    $setting[$key] = $settings[$key] ?? ($default[$key] ?? null);
                }
                break;
            default :
                $setting = self::query()
                    ->pluck('value', 'key')
                    ->toArray();
        }
        return $setting;
    }

    public static function saveSetting(string|array $key, string $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                self::query()
                    ->updateOrCreate([
                        'key' => $k,
                    ], [
                        'value' => $v,
                    ]);
            }
        } else if (gettype($key) == 'string') {
            self::query()
                ->updateOrCreate([
                    'key' => $key,
                ], [
                    'value' => $value,
                ]);
        }
    }

    public static function getDashboard() {
        $settings = self::getSetting([
            'play_icon', 'play_link',
            'improve_icon', 'improve_link',
            'rent_icon', 'rent_link',
            'shop_icon', 'shop_link',
        ]);
        if (!is_file(public_path($settings['play_icon']))) {
            $settings['play_icon'] = 'img/dashboard/play.png';
        }
        $settings['play_icon'] = asset($settings['play_icon']);
        if (!is_file(public_path($settings['improve_icon']))) {
            $settings['improve_icon'] = 'img/dashboard/improve.png';
        }
        $settings['improve_icon'] = asset($settings['improve_icon']);
        if (!is_file(public_path($settings['rent_icon']))) {
            $settings['rent_icon'] = 'img/dashboard/rent.png';
        }
        $settings['rent_icon'] = asset($settings['rent_icon']);
        if (!is_file(public_path($settings['shop_icon']))) {
            $settings['shop_icon'] = 'img/dashboard/shop.png';
        }
        $settings['shop_icon'] = asset($settings['shop_icon']);
        return $settings;
    }

    public static function getSocialMedia() {
        $settings = self::getSetting([
            'social1_icon', 'social1_link',
            'social2_icon', 'social2_link',
            'social3_icon', 'social3_link',
        ]);
        if (!is_file(public_path($settings['social1_icon']))) {
            $settings['social1_icon'] = 'img/social-media/1.png';
        }
        $settings['social1_icon'] = asset($settings['social1_icon']);
        if (!is_file(public_path($settings['social2_icon']))) {
            $settings['social2_icon'] = 'img/social-media/2.png';
        }
        $settings['social2_icon'] = asset($settings['social2_icon']);
        if (!is_file(public_path($settings['social3_icon']))) {
            $settings['social3_icon'] = 'img/social-media/3.png';
        }
        $settings['social3_icon'] = asset($settings['social3_icon']);
        return $settings;
    }
}
