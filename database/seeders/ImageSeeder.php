<?php

namespace Database\Seeders;

use App\Http\Services\ImageService;
use App\Models\Image;
use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;

class ImageSeeder extends Seeder
{
    protected $imageService;
    public function __construct(ImageService $imageService){
        $this->imageService = $imageService;
    }

    // Mapping images for seeding with related vehicles id
    protected $imageMappings = [
    'audi_a4.png' => 1,
    'bmw3.png' => 2,
    'tucson.png' => 3,
    'range_rover.png' => 4,
    'mazda6.png' => 5,
    'e_class.png' => 6,
    'qashqai.png' => 7,
    'peugeot_508.png' => 8,
    'superb.png' => 9,
    'passat.png' => 10,
    'xc_60.png' => 11
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        foreach ($this->imageMappings as $imageFile => $vehicleId) {

            $img = public_path('seeder_images/'.$imageFile);
            $uploadedFile = new UploadedFile($img, $imageFile);

            $vehicle = Vehicle::query()->find($vehicleId);

            if ($vehicle) {
                $this->imageService->storeImage($uploadedFile, $vehicle);
            }
        }
    }
}
