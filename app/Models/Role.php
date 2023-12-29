<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public const PERMISSION_DASHBOARD  = 1;
    public const PERMISSION_LOCATIONS  = 2;
    public const PERMISSION_MEMBERS    = 3;
    public const PERMISSION_ACTIVITY   = 4;
    public const PERMISSION_INVOICES   = 5;
    public const PERMISSION_USERS      = 6;
    public const PERMISSION_SETTINGS   = 7;
    public const PERMISSION_SCAN       = 8;

    protected $fillable = [
        'name', 'permissions'
    ];

    public function users() {
        return $this->hasMany(User::class);
    }

    public function hasPermission($permission) {
        return in_array($permission, explode(',', $this['permissions']));
    }

    public static function getAllPermissions() {
        return [
            self::PERMISSION_DASHBOARD => [
                'label' => 'Dashboard',
                'route' => route('dashboard'),
                'pattern' => 'dashboard',
            ],
            self::PERMISSION_LOCATIONS => [
                'label' => 'Locations',
                'route' => route('locations.index'),
                'pattern' => 'locations.*',
            ],
            self::PERMISSION_MEMBERS => [
                'label' => 'Members',
                'route' => route('members.index'),
                'pattern' => 'members.*',
            ],
            self::PERMISSION_ACTIVITY => [
                'label' => 'Activity',
                'route' => route('activity.index'),
                'pattern' => 'activity.*',
            ],
            self::PERMISSION_INVOICES => [
                'label' => 'Invoices',
                'route' => route('invoices.index'),
                'pattern' => 'invoices.*',
            ],
            self::PERMISSION_USERS => [
                'label' => 'Users',
                'route' => route('users.index'),
                'pattern' => 'users.*',
            ],
            self::PERMISSION_SETTINGS => [
                'label' => 'Settings',
                'route' => route('settings.index'),
                'pattern' => 'settings.*',
            ],
            self::PERMISSION_SCAN => [
                'label' => 'Scan',
                'route' => route('scan.index'),
                'pattern' => 'scan',
            ],
        ];
    }

    public static function getPermissionsRule() {
        return 'in:'.implode(',', array_keys(self::getAllPermissions()));
    }
}
