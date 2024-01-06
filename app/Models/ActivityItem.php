<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'name',
        'price',
    ];

    public function activity() {
        return $this->belongsTo(Activity::class);
    }
}
