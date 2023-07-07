<?php

namespace Database\Seeders;

use App\Http\Services\DocumentService;
use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;

class DocumentSeeder extends Seeder
{
    protected $documentService;

    public function  __construct(DocumentService $documentService){
        $this->documentService = $documentService;
    }
    protected $documentMappings = [
        'audi_a4.pdf' => 1,
        'bmw3.pdf' => 2,
        'tucson.pdf' => 3,
        'range_rover.pdf' => 4,
        'mazda6.pdf' => 5,
        'e_class.pdf' => 6,
        'qashqai.pdf' => 7,
        'peugeot_508.pdf' => 8,
        'superb.pdf' => 9,
        'passat.pdf' => 10,
        'xc_60.pdf' => 11
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->documentMappings as $documentFile => $vehicleId) {

            $doc = public_path('seeder_docs/'.$documentFile);
            $uploadedFile = new UploadedFile($doc, $documentFile);

            $vehicle = Vehicle::query()->find($vehicleId);

            if ($vehicle) {
                $this->documentService->storeDocument($uploadedFile, $vehicle);
            }
        }
    }
}
