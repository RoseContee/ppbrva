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
    public const PERMISSIONS = [
        self::PERMISSION_DASHBOARD => 'Dashboard',
        self::PERMISSION_LOCATIONS => 'Locations',
        self::PERMISSION_MEMBERS => 'Members',
        self::PERMISSION_ACTIVITY => 'Activity',
        self::PERMISSION_INVOICES => 'Invoices',
        self::PERMISSION_USERS => 'Users',
        self::PERMISSION_SETTINGS => 'Settings',
    ];

    protected $fillable = [
        'name', 'permissions'
    ];

    public function users() {
        return $this->hasMany(User::class);
    }

    public function hasPermission($permission) {
        return in_array($permission, explode(',', $this['permissions']));
    }

    public static function getPermissions() {
        return array_keys(self::PERMISSIONS);
    }

    public static function getPermissionsRule() {
        return 'in:'.implode(',', self::getPermissions());
    }
}
