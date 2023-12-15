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
        Category::query()->create([
            'name' => 'Food & Beverage',
        ]);
        Category::query()->create([
            'name' => 'Lessons',
        ]);
        Category::query()->create([
            'name' => 'Court Usage',
        ]);
        Category::query()->create([
            'name' => 'Rentals',
        ]);
        Category::query()->create([
            'name' => 'Merchandise',
        ]);
    }
}
