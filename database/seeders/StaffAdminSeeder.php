<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StaffAdmin; // Ensure the correct model path
use Illuminate\Support\Facades\Hash;

class StaffAdminSeeder extends Seeder
{
    public function run()
    {
        StaffAdmin::create([
            'firstname' => 'John',
            'lastname' => 'Doe',
            'email' => 'staffadmin@example.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
