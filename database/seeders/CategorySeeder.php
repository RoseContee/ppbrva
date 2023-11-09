<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Food & Beverage',
        ]);

        Category::create([
            'name' => 'Lessons',
        ]);

        Category::create([
            'name' => 'Court Usage',
        ]);

        Category::create([
            'name' => 'Rentals',
        ]);

        Category::create([
            'name' => 'Merchandise',
        ]);
    }
}
