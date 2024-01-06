<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoiceID', 'member_id', 'period', 'amount', 'paid',
        'card_type', 'card_last4', 'paid_at',
        'reason',
    ];

    protected $appends = [
        'period_timestamp',
    ];

    public function getPeriodTimeStampAttribute() {
        return strtotime($this->attributes['period']);
    }

    public function member() {
        return $this->belongsTo(Member::class)->withDefault([
            'memberID' => '',
            'name' => '',
        ]);
    }

    public function activities() {
        return $this->hasMany(Activity::class);
    }

    public function plans() {
        return $this->hasMany(InvoicePlan::class);
    }
}
