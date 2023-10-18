<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Member extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'memberID', 'name', 'email', 'password', 'origin_pass',
        'phone', 'location_id', 'plan_id', 'avatar',
        'customer_id', 'card_id', 'active',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function location() {
        return $this->belongsTo(Location::class);
    }

    public function plan() {
        return $this->belongsTo(Plan::class);
    }

    public function profile() {
        return $this->hasOne(MemberProfile::class);
    }
}
