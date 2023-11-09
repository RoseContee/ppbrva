<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'member_id', 'period', 'amount', 'paid',
        'plan_name', 'plan_price', 'card_type', 'card_last4', 'paid_at',
    ];

    public function member() {
        return $this->belongsTo(Member::class);
    }

    public function activities() {
        return $this->hasMany(Activity::class);
    }
}
