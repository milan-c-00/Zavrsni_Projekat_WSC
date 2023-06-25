<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    protected $brandModels = [
        'Audi' => [
            'A4' => ['year' => 2014, 'price' => 50, 'fuel' => 'Diesel', 'doors' => 5, 'description' => '' ]
        ],
        'BMW' => [
            '3 Series' => ['year' => 2015, 'price' => 50, 'fuel' => 'Diesel', 'doors' => 5, 'description' => '' ]
        ],
        'Hyundai' => [
            'Tucson' => ['year' => 2017, 'price' => 45, 'fuel' => 'Diesel', 'doors' => 5, 'description' => '' ]
        ],
        'Land Rover' => [
            'Range Rover' => ['year' => 2015, 'price' => 100, 'fuel' => 'Diesel', 'doors' => 5, 'description' => '' ]
        ],
        'Mazda' => [
            'Mazda6' => ['year' => 2014, 'price' => 60, 'fuel' => 'Diesel', 'doors' => 5, 'description' => '' ],
        ],
        'Mercedes Benz' => [
            'E-Class' => ['year' => 2018, 'price' => 80, 'fuel' => 'Diesel', 'doors' => 5, 'description' => '' ],
        ],
        'Nissan' => [
            'Qashqai' => ['year' => 2014, 'price' => 35, 'fuel' => 'Diesel', 'doors' => 5, 'description' => '' ]
        ],
        'Peugeot' => [
            '508' => ['year' => 2014, 'price' => 50, 'fuel' => 'Diesel', 'doors' => 5, 'description' => '' ]
        ],
        'Skoda' => [
            'Superb' => ['year' => 2016, 'price' => 55, 'fuel' => 'Diesel', 'doors' => 5, 'description' => '' ]
        ],
        'Volkswagen' => [
            'Passat' => ['year' => 2014, 'price' => 50, 'fuel' => 'Diesel', 'doors' => 5, 'description' => '' ]
        ],
        'Volvo' => [
            'XC60' => ['year' => 2016, 'price' => 85, 'fuel' => 'Diesel', 'doors' => 5, 'description' => '' ]
        ]
    ];


    public function run(): void
    {
        // Seeding vehicles as given in array, models for brands, and specs for models

        foreach ($this->brandModels as $brandName => $models) {
            $brand = Brand::query()->where('name', $brandName)->firstOrFail();

            foreach ($models as $modelName => $specs) {
                $model = VehicleModel::query()->where('name', $modelName)->firstOrFail();
                Vehicle::query()->create([
                    'brand_id' => $brand->id,
                    'vehicle_model_id' => $model->id,
                    'year' => $specs['year'],
                    'price' => $specs['price'],
                    'fuel' => $specs['fuel'],
                    'doors' => $specs['doors'],
                    'description' => $specs['description']
                ]);
            }
        }
    }
}
