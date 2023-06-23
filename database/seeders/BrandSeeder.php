<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    protected $brands = [
        'Audi',
        'BMW',
        'Citroen',
        'Dacia',
        'Ford',
        'Hyundai',
        'Kia',
        'Land Rover',
        'Mazda',
        'Mercedes Benz',
        'Nissan',
        'Opel',
        'Peugeot',
        'Renault',
        'Seat',
        'Skoda',
        'Toyota',
        'Volkswagen',
        'Volvo'
    ];

    public function run(): void
    {
        foreach ($this->brands as $brand) {
            Brand::query()->create([
                'name' => $brand
            ]);
        }
    }
}
