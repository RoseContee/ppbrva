<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Member extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'memberID', 'name', 'email', 'password', 'original_pass',
        'phone', 'location_id', 'plan_id', 'avatar',
        'customer_id', 'card_last4', 'card_type',
        'active',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function getAvatarAttribute() {
        if (is_file(public_path($this->attributes['avatar']))) {
            return asset($this->attributes['avatar']);
        }
        return asset('img/user-profile.png');
    }

    public function scopeActive($query) {
        $query->where('active', true);
    }

    public function location() {
        return $this->belongsTo(Location::class);
    }

    public function plan() {
        return $this->belongsTo(Plan::class);
    }

    public function profile() {
        return $this->hasOne(MemberProfile::class);
    }

    public function activities() {
        return $this->hasMany(Activity::class);
    }

    public function invoices() {
        return $this->hasMany(Invoice::class);
    }

    public function removeAvatar() {
        $avatar = public_path($this->attributes['avatar']);
        if (is_file($avatar)) unlink($avatar);
    }

    public function getInfo() {
        $this['original_pass'] = !empty($this->original_pass);
        $this['profile'] = $this->profile;
        $this['location'] = $this->location;
        $this['plan'] = $this->plan;
        return $this;
    }
}
