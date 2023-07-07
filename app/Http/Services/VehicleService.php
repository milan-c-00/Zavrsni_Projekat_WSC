<?php

namespace App\Http\Services;

use App\Http\Controllers\api\DocumentController;
use App\Http\Controllers\api\ImageController;
use App\Http\Requests\StoreVehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\Translation\t;


class VehicleService
{
    protected $imageController;
    protected $documentController;
    public function __construct(ImageController $imageController, DocumentController $documentController){
        $this->imageController = $imageController;
        $this->documentController = $documentController;
    }

    // Getting all vehicles and ability to filter them based on multiple params
    // Brand and model based search depends on using name or id for search
    // Term based search works with brands and models name
    public function index(Request $request) {

        $vehicles = Vehicle::query();

        if ($request->has('min_price')){
            $min_price = $request->input('min_price');
            $vehicles->where('price', '>=', $min_price);
        }
        if ($request->has('max_price')){
            $max_price = $request->input('max_price');
            $vehicles->where('price', '<=', $max_price);
        }
        if($request->has('year')){
            $year = $request->input('year');
            $vehicles->where('year', '=', $year);
        }
        if ($request->has('brand_id')){
            $brand_id = $request->input('brand_id');
            $vehicles->where('brand_id', $brand_id);
        }
        if ($request->has('model_id')){
            $model_id = $request->input('model_id');
            $vehicles->where('vehicle_model_id', $model_id);
        }

        // Only if we had name based search for some reason
//        if ($request->has('brand_name')){
//            $brand_name = $request->input('brand_name');
//            $vehicles->join('brands', 'vehicles.brand_id', '=', 'brands.id')
//                ->where('brands.name', '=', $brand_name);
//        }
//        if ($request->has('model_name')){
//            $model_name = $request->input('model_name');
//            $vehicles->join('vehicle_models', 'vehicles.vehicle_model_id', '=', 'vehicle_models.id')
//                ->where('vehicle_models.name' , '=', $model_name);
//        }

        if ($request->has('search_term')){
            $term = $request->input('search_term');
            $vehicles->join('brands', 'vehicles.brand_id', '=', 'brands.id')
                ->join('vehicle_models', 'vehicles.vehicle_model_id', '=', 'vehicle_models.id')
                ->where('brands.name', 'LIKE', "%$term%")
                ->orWhere('vehicle_models.name', 'LIKE', "%$term%")
                ->select('vehicles.*', 'brands.name as brand_name', 'vehicle_models.name as model_name');
        }

        return $vehicles->get();
        //return $vehicles->paginate(10);   // Depends on requirements

    }

    // Get a single vehicle
    public function show(Vehicle $vehicle) {
        return Vehicle::query()->where('id', $vehicle->id)->exists();
    }

    // Create and store a new vehicle (for admin)
    public function store(StoreVehicleRequest $request) {
        $vehicle = Vehicle::query()->create($request->validated());
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $this->imageController->storeVehicleImage($vehicle, $request);
        }
        if ($request->hasFile('specs') && $request->file('specs')->isValid()) {
            $this->documentController->storeVehicleDocument($vehicle, $request);
        }
        return $vehicle;
    }

    // Update existing vehicle (for admin)
    public function update(Vehicle $vehicle, $validated, $request) {
        $updatedVehicle = $vehicle->update($validated);
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $this->imageController->updateVehicleImage($vehicle, $request);
        }
        if ($request->hasFile('specs') && $request->file('specs')->isValid()) {
            $this->documentController->updateVehicleDocument($vehicle, $request);
        }
        return $updatedVehicle;
    }

    // Delete a vehicle (for admin)
    public function destroy(Vehicle $vehicle) {
        if($vehicle->image){
            $this->imageController->deleteImage($vehicle->image);
        }
        if($vehicle->document){
            $this->documentController->deleteDocument($vehicle->document);
        }
        return $vehicle->delete();
    }

}
