<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id', 'location_id',
    ];

    protected $appends = [
        'timestamp',
    ];

    public function getTimestampAttribute() {
        return date('n/j/y @ h:iA', strtotime($this->attributes['created_at']));
    }

    public function member() {
        return $this->belongsTo(Member::class);
    }

    public function location() {
        return $this->belongsTo(Location::class)->withDefault([
            'name' => '',
        ]);
    }
}
