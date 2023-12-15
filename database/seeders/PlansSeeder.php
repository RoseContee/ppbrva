<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::query()->create([
            'name' => 'Elite Team Membership',
            'price' => 119,
            'period' => 'monthly',
            'status' => 'public',
        ]);
        Plan::query()->create([
            'name' => 'Performance Team Membership',
            'price' => 49,
            'period' => 'monthly',
            'status' => 'public',
        ]);
        Plan::create([
            'name' => 'Corporate Membership',
            'price' => 99,
            'period' => 'monthly',
            'status' => 'public',
        ]);
        Plan::create([
            'name' => 'Morning Crew PBJ Membership',
            'price' => 49,
            'period' => 'monthly',
            'status' => 'private',
        ]);
        Plan::create([
            'name' => 'Student Membership',
            'price' => 39,
            'period' => 'monthly',
            'status' => 'public',
        ]);
        Plan::create([
            'name' => 'Elite Team Membership (DISCOUNTED)',
            'price' => 99,
            'period' => 'monthly',
            'status' => 'private',
        ]);
        Plan::create([
            'name' => 'Performance Team Membership (DISCOUNTED)',
            'price' => 39,
            'period' => 'monthly',
            'status' => 'private',
        ]);
    }
}
