<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reviews')->insert([
            ['name' => 'Oliver', 'review' => 'Amazing service!', 'rating' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jay', 'review' => 'Very professional!', 'rating' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cresha', 'review' => 'Would recommend!', 'rating' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Allen', 'review' => 'Would recommend!', 'rating' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Emman', 'review' => 'Would recommend!', 'rating' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Rio', 'review' => 'Would recommend!', 'rating' => 5, 'created_at' => now(), 'updated_at' => now()],
        
        
        
        
        
        ]); 
    }
}
