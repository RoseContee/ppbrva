<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'category', // [Location] + POS from clover / Category from admin
        'detail', // order ID from clover / Detail from admin
        'price',
        'date',
        'from', // clover/admin
        'invoiceID',
    ];

    protected $casts = [
        'date' => 'date:n/j/y',
    ];

    protected $appends = [
        'timestamp',
    ];

    public function getTimestampAttribute() {
        return strtotime($this->attributes['date'] ?? 0);
    }

    public function scopeEditable($query) {
        $query->where('from', 'admin')
            ->whereNull('invoiceID');
    }

    public function member() {
        return $this->belongsTo(Member::class)->withDefault([
            'memberID' => '',
            'name' => '',
        ]);
    }

    public function invoice() {
        return $this->belongsTo(Invoice::class, 'invoiceID', 'invoiceID');
    }

    public function items() {
        return $this->hasMany(ActivityItem::class, 'orderID', 'detail');
    }
}
