<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Http\Services\ImageService;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ImageController extends Controller
{
    protected $imageService;

    public function  __construct(ImageService $imageService) {
        $this->imageService = $imageService;
    }

    // Store image related to a vehicle upon creating it
    public function storeVehicleImage($vehicle, StoreVehicleRequest $request){

        $vehicle_img = $this->imageService->storeImage($request->file('image'), $vehicle);
        if(!$vehicle_img) {
            return response(['message' => 'Unprocessable entity!'], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response (['message' => 'Image uploaded!'],ResponseAlias::HTTP_OK);
    }

    public function updateVehicleImage($vehicle, UpdateVehicleRequest $request) {

        if($vehicle->image)
            $this->imageService->deleteImage($vehicle->image);
        $vehicle_img = $this->imageService->storeImage($request->file('image'), $vehicle);
        if(!$vehicle_img) {
            return response(['message' => 'Unprocessable entity!'], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }
        return response (['message' => 'Image updated!'],ResponseAlias::HTTP_OK);
    }

    public function deleteImage(Image $image) {

        $this->imageService->deleteImage($image);
        return response(['message' => 'Delete successful!'], ResponseAlias::HTTP_OK);

    }

}
