<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KitchenBar extends Model
{
    use HasFactory;

    protected $fillable = [
        'itemID', 'item', 'price', 'category', 'sortOrder',
    ];
}
