<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'address', 'lat', 'lng', 'phone', 'email', 'website', 'image',
    ];

    public function getImageAttribute() {
        if (is_file(public_path($this->attributes['image'] ?? ''))) {
            return asset($this->attributes['image']);
        }
        return null;
    }
}
