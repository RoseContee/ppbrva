<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appicon extends Model
{
    use HasFactory;

    public static int $play = 1;
    public static int $improve = 2;
    public static int $rent = 3;
    public static int $shop = 4;

    protected $fillable = [
        'id', 'icon',
    ];

    public function getIconAttribute() {
        if (is_file(public_path($this->attributes['icon']))) {
            return asset($this->attributes['icon']);
        }
        return null;
    }

    public static function getIcons() {
        $appicons = self::pluck('icon', 'id');
        return [
            'play' => $appicons[self::$play] ?? asset('img/play.png'),
            'improve' => $appicons[self::$improve] ?? asset('img/improve.png'),
            'rent' => $appicons[self::$rent] ?? asset('img/rent.png'),
            'shop' => $appicons[self::$shop] ?? asset('img/shop.png'),
        ];
    }

    public function removeIcon() {
        $icon = public_path($this->attributes['icon']);
        if (is_file($icon)) unlink($icon);
    }
}
