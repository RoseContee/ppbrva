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
        'customer_id', 'card_id', 'card_last4', 'active',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

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

    public function getInfo($member) {
        $member['original_pass'] = !empty($member['original_pass']);
        if ($member['avatar'] && file_exists(public_path($member['avatar']))) {
            $member['avatar'] = asset($member['avatar']);
        } else {
            $member['avatar'] = null;
        }
        $member['profile'] = $member['profile'];
        $member['location'] = $member['location'];
        if ($member['location']) {
            if ($member['location']['image'] && file_exists(public_path($member['location']['image']))) {
                $member['location']['image'] = asset($member['location']['image']);
            } else {
                $member['location']['image'] = null;
            }
        }
        $member['plan'] = $member['plan'];
        return $member;
    }
}
