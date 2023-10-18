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
        'age', 'gender', 'rating', 'city', 'state',
    ];

    public function member() {
        return $this->belongsTo(Member::class);
    }
}
