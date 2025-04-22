<?php

namespace Database\Seeders;

use App\Models\DriverAdmin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DriverAdminSeeder extends Seeder
{
    public function run(): void
    {
        DriverAdmin::create([
            'firstname' => 'Brent',
            'lastname' => 'Manalo',
            'email' => 'driveradmin@example.com',
            'password' => Hash::make('password123'), 
        ]);
    }
}
