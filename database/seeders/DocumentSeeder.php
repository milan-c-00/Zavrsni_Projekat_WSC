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
        'audi_a4.xlsx' => 1,
        'bmw3.docx' => 2,
        'tucson.docx' => 3,
        'range_rover.docx' => 4,
        'mazda6.docx' => 5,
        'e_class.docx' => 6,
        'qashqai.docx' => 7,
        'peugeot_508.docx' => 8,
        'superb.docx' => 9,
        'passat.docx' => 10,
        'xc_60.docx' => 11
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
