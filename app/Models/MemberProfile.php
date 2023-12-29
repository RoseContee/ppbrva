<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberProfile extends Model
{
    use HasFactory;

    protected $primaryKey = 'member_id';

    protected $fillable = [
        'member_id', 'share_age_gender',
        'dupr_id', 'gender', 'age', 'rating', 'matches', 'wins', 'losses',
    ];

    public function getRatingAttribute() {
        return $this->attributes['rating'] ?? '-';
    }

    public function getMatchesAttribute() {
        return $this->attributes['matches'] ?? '-';
    }

    public function getWinsAttribute() {
        return $this->attributes['wins'] ?? '-';
    }

    public function getLossesAttribute() {
        return $this->attributes['losses'] ?? '-';
    }

    public function member() {
        return $this->belongsTo(Member::class);
    }
}
