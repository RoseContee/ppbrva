<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key', 'value',
    ];

    public static function getSetting(array|string $keys = null, string $default = null): array|string|null
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

    public static function saveSetting(array|string $key, string $value = null)
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
}
