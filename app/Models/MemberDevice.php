<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id', 'token',
    ];

    public function member() {
        return $this->belongsTo(Member::class);
    }
}
