<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin; // Adjust this if your admin model is named differently

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Create an admin user
        Admin::create([
            'email' => 'itsmecreshapritz@gmail.com',
            'password' => Hash::make('password123'), // Use a strong password here
        ]);
    }
}
