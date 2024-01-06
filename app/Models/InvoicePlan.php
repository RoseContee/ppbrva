<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id', 'member_id', 'name', 'price',
    ];

    public function invoice() {
        return $this->belongsTo(Invoice::class);
    }

    public function member() {
        return $this->belongsTo(Member::class);
    }
}
