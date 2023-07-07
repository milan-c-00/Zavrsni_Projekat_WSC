<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Http\Services\DocumentService;
use App\Http\Services\ImageService;
use App\Models\Document;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use PhpParser\Comment\Doc;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class DocumentController extends Controller
{

    protected $documentService;

    public function  __construct(DocumentService $documentService) {
        $this->documentService = $documentService;
    }

    // Store image related to a vehicle upon creating it
    public function storeVehicleDocument($vehicle, StoreVehicleRequest $request){

        $vehicle_doc = $this->documentService->storeDocument($request->file('specs'), $vehicle);
        if(!$vehicle_doc) {
            return response(['message' => 'Unprocessable entity!'], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response (['message' => 'Document uploaded!'],ResponseAlias::HTTP_OK);
    }

    public function updateVehicleDocument($vehicle, UpdateVehicleRequest $request) {

        if($vehicle->document)
            $this->documentService->deleteDocument($vehicle->document);
        $vehicle_doc = $this->documentService->storeDocument($request->file('specs'), $vehicle);
        if(!$vehicle_doc) {
            return response(['message' => 'Unprocessable entity!'], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response (['message' => 'Document updated!'],ResponseAlias::HTTP_OK);
    }

    public function deleteDocument(Document $document) {

        $this->documentService->deleteDocument($document);
        return response(['message' => 'Delete successful!'], ResponseAlias::HTTP_OK);

    }
}
