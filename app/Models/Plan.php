<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use HasFactory, SoftDeletes;

    public const FamilyPlanId = 8;

    protected $fillable = [
        'name', 'price', 'period', 'status',
    ];

    public function members() {
        return $this->hasMany(Member::class);
    }
}
