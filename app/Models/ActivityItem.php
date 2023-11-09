<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', // detail in activities table
        'name',
        'price',
    ];

    public function activity() {
        return $this->belongsTo(Activity::class, 'order_id', 'detail');
    }
}
