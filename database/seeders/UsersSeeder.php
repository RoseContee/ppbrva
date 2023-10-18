<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Jim Doyle',
            'email' => 'jim@divstrong.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123456'),
            'role_id' => 1, // Admin
            'active' => true,
        ]);
    }
}
