<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PartnerAdmin;
use Illuminate\Support\Facades\Hash;

class PartnerAdminSeeder extends Seeder
{
    public function run()
    {
        PartnerAdmin::create([
            'name' => 'Partner One',
            'email' => 'partner1@arkila.com',
            'password' => Hash::make('password123'), 
        ]);

        echo "Partner Admin seeded successfully!";
    }
}
