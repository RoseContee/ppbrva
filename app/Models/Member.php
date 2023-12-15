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
        'memberID', 'firstname', 'lastname', 'email', 'password', 'original_pass',
        'gender', 'phone', 'dob', 'address', 'city', 'state', 'zipcode',
        'location_id', 'plan_id', 'membership_card_id', 'avatar',
        'customerID', 'card_last4', 'card_type',
        'status', 'pause_from', 'pause_to',
    ];

    protected $appends = [
        'name',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function getNameAttribute() {
        return ($this->attributes['firstname'] ?? '').' '.($this->attributes['lastname'] ?? '');
    }

    public function getOriginalPassAttribute() {
        return !!$this->attributes['original_pass'];
    }

    public function getAvatarAttribute() {
        if (is_file(public_path($this->attributes['avatar']))) {
            return asset($this->attributes['avatar']);
        }
        return asset('img/user-profile.png');
    }

    public function location() {
        return $this->belongsTo(Location::class)->withDefault();
    }

    public function plan() {
        return $this->belongsTo(Plan::class)->withDefault();
    }

    public function profile() {
        return $this->hasOne(MemberProfile::class)->withDefault();
    }

    public function activities() {
        return $this->hasMany(Activity::class);
    }

    public function invoices() {
        return $this->hasMany(Invoice::class);
    }

    public function friends1() {
        return $this->belongsToMany(Member::class, 'member_friend', 'member2_id', 'member1_id')
            ->as('relation');
    }

    public function friends2() {
        return $this->belongsToMany(Member::class, 'member_friend', 'member1_id', 'member2_id')
            ->as('relation');
    }

    public function removeAvatar() {
        $avatar = public_path($this->attributes['avatar']);
        if (is_file($avatar)) unlink($avatar);
    }

    public function getInfo() {
        $profile = $this['profile'];
        $location = $this['location'];
        $plan = $this['plan'];
        return [
            'id' => $this['id'],
            'memberID' => $this['memberID'],
            'firstname' => $this['firstname'],
            'lastname' => $this['lastname'],
            'name' => $this['name'],
            'email' => $this['email'],
            'original_pass' => $this['original_pass'],
            'gender' => $this['gender'],
            'phone' => $this['phone'],
            'dob' => $this['dob'] ? date('m/d/Y', strtotime($this['dob'])) : null,
            'address' => $this['address'],
            'city' => $this['city'],
            'state' => $this['state'],
            'zipcode' => $this['zipcode'],
            'avatar' => $this['avatar'],
            'card_type' => $this['card_type'],
            'card_last4' => $this['card_last4'],
            'status' => $this['status'],
            'profile' => [
                'share_age_gender' => !empty($profile['share_age_gender']),
                'dupr_id' => $profile['dupr_id'],
                'dupr_link' => Setting::getSetting('dupr_link'),
                'gender' => $profile['gender'],
                'age' => $profile['age'],
                'rating' => $profile['rating'],
                'matches' => $profile['matches'],
                'wins' => $profile['wins'],
                'losses' => $profile['losses'],
            ],
            'location' => [
                'name' => $location['name'],
                'address' => $location['address'],
                'lat' => $location['lat'],
                'lng' => $location['lng'],
                'phone' => $location['phone'],
                'email' => $location['email'],
                'website' => $location['website'],
                'image' => $location['image'],
            ],
            'plan' => [
                'id' => $plan['id'],
                'name' => $plan['name'],
            ],
        ];
    }
}
