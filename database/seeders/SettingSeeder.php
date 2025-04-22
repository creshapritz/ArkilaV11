<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    public function run()
    {
        DB::table('settings')->updateOrInsert(
            ['key' => 'site_logo'],
            ['value' => 'logo2.png'] // You should place this file in public/storage/logos/
        );
    }
}