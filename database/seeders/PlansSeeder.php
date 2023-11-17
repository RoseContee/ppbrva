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
        Plan::create([
            'name' => 'Elite Team Membership',
            'price' => 119,
            'period' => 'monthly',
        ]);

        Plan::create([
            'name' => 'Performance Team Membership',
            'price' => 49,
            'period' => 'monthly',
        ]);

        Plan::create([
            'name' => 'Corporate Membership',
            'price' => 99,
            'period' => 'monthly',
        ]);

        Plan::create([
            'name' => 'Morning Crew PBJ Membership',
            'price' => 49,
            'period' => 'monthly',
        ]);

        Plan::create([
            'name' => 'Student Membership Membership',
            'price' => 39,
            'period' => 'monthly',
        ]);
    }
}
