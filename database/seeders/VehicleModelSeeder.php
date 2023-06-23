<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\VehicleModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

public $brandModels = [
    'Audi' => [
        'A3',
        'A4',
        'A5',
        'A6',
        'A7',
        'Q3',
        'Q5',
        'Q7',
        'Q8'
    ],
    'BMW' => [
        'X1',
        'X3',
        'X4',
        'X5',
        'X6',
        '3 Series',
        '4 Series',
        '5 Series',
        '7 Series',
        '8 Series'
    ],
    'Citroen' => [
        'C3',
        'C4',
        'C5',
        'Cactus'
    ],
    'Dacia' => [
        'Sandero',
        'Duster',
        'Logan',
        'Lodgy',
        'Dokker'
    ],
    'Ford' => [
        'Fiesta',
        'Focus',
        'Mondeo',
        'Mustang',
        'Kuga',
        'Edge',
        'Explorer'
    ],
    'Hyundai' => [
        'i10',
        'i20',
        'i30',
        'Elantra',
        'Tucson',
        'Kona',
        'Santa Fe',
        'Veloster'
    ],
    'Kia' => [
        'Picanto',
        'Rio',
        'Ceed',
        'Sportage',
        'Sorento',
        'Stinger',
        'Optima'
    ],
    'Land Rover' => [
        'Range Rover',
        'Range Rover Sport',
        'Range Rover Velar',
        'Range Rover Evoque',
        'Discovery',
        'Defender',
        'Freelander'
    ],
    'Mazda' => [
        'Mazda2',
        'Mazda3',
        'Mazda6',
        'CX-3',
        'CX-5',
        'CX-9',
    ],
    'Mercedes Benz' => [
        'A-Class',
        'C-Class',
        'E-Class',
        'G-Class',
        'S-Class',
        'GLA',
        'GLC',
        'GLE',
        'GLK'
    ],
    'Nissan' => [
        'Micra',
        'Note',
        'Juke',
        'Qashqai',
        'X-Trail',
        'Leaf',
        'Navara',
        'Pathfinder'
    ],
    'Opel' => [
        'Corsa',
        'Astra',
        'Insignia',
        'Mokka',
        'Crossland',
        'Grandland',
        'Zafira'
    ],
    'Peugeot' => [
        '208',
        '308',
        '508',
        '2008',
        '3008',
        '5008',
        'Rifter'
    ],
    'Renault' => [
        'Clio',
        'Megane',
        'Captur',
        'Kadjar',
        'Scenic',
        'Talisman',
        'Koleos'
    ],
    'Seat' => [
        'Ibiza',
        'Leon',
        'Arona',
        'Ateca',
        'Tarraco',
        'Alhambra',
        'Mii'
    ],
    'Skoda' => [
        'Octavia',
        'Superb',
        'Kodiaq',
        'Karoq',
        'Scala',
        'Fabia',
        'Rapid'
    ],
    'Toyota' => [
        'Yaris',
        'Corolla',
        'Camry',
        'C-HR',
        'Rav4',
        'Highlander',
        'Land Cruiser'
    ],
    'Volkswagen' => [
        'Golf',
        'Passat',
        'Tiguan',
        'T-Roc',
        'Polo',
        'Arteon',
        'Touran'
    ],
    'Volvo' => [
        'S60',
        'S90',
        'V60',
        'V90',
        'XC40',
        'XC60',
        'XC90'
    ]
];

    public function run(): void
    {
        foreach ($this->brandModels as $brandName => $models) {
            $brand = Brand::query()->where('name', $brandName)->firstOrFail();

            foreach ($models as $modelName) {
                VehicleModel::query()->create([
                    'name' => $modelName,
                    'brand_id' => $brand->id
                ]);
            }
        }
    }
}
