<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;

class CarSeeder extends Seeder
{
    public function run()
    {
        Car::create([
            'name' => 'Toyota Corolla',
            'brand' => 'Toyota',
            'type' => 'Sedan',
            'location' => 'Angono',
            'price_per_day' => 2300,
            'availability' => true,
            'image' => '/assets/img/car5.png',
            'seating_capacity' => 5,
            'num_bags' => 4,
            'gas_type' => 'Gasoline',
            'transmission' => 'Automatic',
        ]);
        
        Car::create([
            'name' => 'Honda Civic',
            'brand' => 'Honda',
            'type' => 'Sedan',
            'location' => 'Manila',
            'price_per_day' => 2500,
            'availability' => true,
            'image' => '/assets/img/car4.png',
            'seating_capacity' => 5,
            'num_bags' => 4,
            'gas_type' => 'Diesel',
            'transmission' => 'Manual',
        ]);
        
        Car::create([
            'name' => 'Mitsubishi Mirage',
            'brand' => 'Mitsubishi',
            'type' => 'Hatchback',
            'location' => 'Rizal',
            'price_per_day' => 2500,
            'availability' => true,
            'image' => '/assets/img/car2.png',
            'seating_capacity' => 4,
            'num_bags' => 2,
            'gas_type' => 'Gasoline',
            'transmission' => 'Automatic',
        ]);
        
        Car::create([
            'name' => 'Mitsubishi Mirage',
            'brand' => 'Mitsubishi',
            'type' => 'Hatchback',
            'location' => 'Antipolo',
            'price_per_day' => 2300,
            'availability' => true,
            'image' => '/assets/img/car3.png',
            'seating_capacity' => 4,
            'num_bags' => 2,
            'gas_type' => 'Gasoline',
            'transmission' => 'Manual',
        ]);
        
        Car::create([
            'name' => 'Mitsubishi Mirage',
            'brand' => 'Mitsubishi',
            'type' => 'Hatchback',
            'location' => 'Binangonan',
            'price_per_day' => 2500,
            'availability' => true,
            'image' => '/assets/img/car2.png',
            'seating_capacity' => 4,
            'num_bags' => 2,
            'gas_type' => 'Diesel',
            'transmission' => 'Automatic',
        ]);
        
        Car::create([
            'name' => 'Mitsubishi Mirage',
            'brand' => 'Mitsubishi',
            'type' => 'Hatchback',
            'location' => 'Taytay',
            'price_per_day' => 2600,
            'availability' => true,
            'image' => '/assets/img/car3.png',
            'seating_capacity' => 4,
            'num_bags' => 2,
            'gas_type' => 'Gasoline',
            'transmission' => 'Manual',
        ]);
        

        // Create new Mitsubishi Mirage entries
        Car::create([
            'name' => 'Mitsubishi Mirage',
            'brand' => 'Mitsubishi',
            'type' => 'Hatchback',
            'location' => 'Antipolo',
            'price_per_day' => 5000,
            'availability' => true,
            'image' => '/assets/img/car5.png',
            'seating_capacity' => 4,
            'num_bags' => 2,
            'gas_type' => 'Diesel',
            'transmission' => 'Automatic',
        ]);

        Car::create([
            'name' => 'Mitsubishi Mirage',
            'brand' => 'Mitsubishi',
            'type' => 'Hatchback',
            'location' => 'Binangonan',
            'price_per_day' => 2500,
            'availability' => true,
            'image' => '/assets/img/car5.png',
            'seating_capacity' => 4,
            'num_bags' => 2,
            'gas_type' => 'Diesel',
            'transmission' => 'Manual',
        ]);

        Car::create([
            'name' => 'Mitsubishi Mirage',
            'brand' => 'Mitsubishi',
            'type' => 'Hatchback',
            'location' => 'Taytay',
            'price_per_day' => 2600,
            'availability' => true,
            'image' => '/assets/img/car4.png',
            'seating_capacity' => 4,
            'num_bags' => 2,
            'gas_type' => 'Gasoline',
            'transmission' => 'Automatic',
        ]);
    }
}
