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
            'id' => 1,
            'name' => 'Elite Team Membership',
            'price' => 119,
            'period' => 'monthly',
            'status' => 'public',
        ]);
        Plan::query()->create([
            'id' => 2,
            'name' => 'Performance Team Membership',
            'price' => 49,
            'period' => 'monthly',
            'status' => 'public',
        ]);
        Plan::query()->create([
            'id' => 3,
            'name' => 'Corporate Membership',
            'price' => 99,
            'period' => 'monthly',
            'status' => 'public',
        ]);
        Plan::query()->create([
            'id' => 4,
            'name' => 'Morning Crew PBJ Membership',
            'price' => 49,
            'period' => 'monthly',
            'status' => 'private',
        ]);
        Plan::query()->create([
            'id' => 5,
            'name' => 'Student Membership',
            'price' => 39,
            'period' => 'monthly',
            'status' => 'public',
        ]);
        Plan::query()->create([
            'id' => 6,
            'name' => 'Elite Team Membership (DISCOUNTED)',
            'price' => 99,
            'period' => 'monthly',
            'status' => 'private',
        ]);
        Plan::query()->create([
            'id' => 7,
            'name' => 'Performance Team Membership (DISCOUNTED)',
            'price' => 39,
            'period' => 'monthly',
            'status' => 'private',
        ]);
        Plan::query()->create([
            'id' => 8,
            'name' => 'Family Plan',
            'price' => 119,
            'period' => 'monthly',
            'status' => 'public',
        ]);
    }
}
