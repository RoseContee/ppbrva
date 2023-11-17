<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberFriend extends Model
{
    use HasFactory;

    protected $table = 'member_friend';

    protected $fillable = [
        'member1_id', 'member1_email', 'member1_phone',
        'member2_id', 'member2_email', 'member2_phone',
        'status',
    ];
}
