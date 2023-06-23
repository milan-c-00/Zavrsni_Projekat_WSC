<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Http\Resources\VehicleResource;
use App\Http\Services\VehicleService;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class VehicleController extends Controller
{
    protected $vehicleService;

    public function __construct(VehicleService $vehicleService) {
        $this->vehicleService = $vehicleService;
    }

    // Get all available vehicles, search implemented for this function
    public function index(Request $request) {
        $vehicles = VehicleResource::collection($this->vehicleService->index($request));
        if(!$vehicles){
            return response(['message' => 'Bad request!'], ResponseAlias::HTTP_BAD_REQUEST);
        }
        return response(['vehicles' => $vehicles], ResponseAlias::HTTP_OK);
    }

    // Get a single vehicle
    public function show(Vehicle $vehicle) {

        if(!$this->vehicleService->show($vehicle)){
            return response(['message' => 'Not found'], ResponseAlias::HTTP_NOT_FOUND);
        }
        return response(['vehicle' => VehicleResource::make($vehicle)], ResponseAlias::HTTP_OK);
    }

    // Create new vehicle
    public function store(StoreVehicleRequest $request) {

        $vehicle = $this->vehicleService->store($request->validated());

        if(!$vehicle)
            return response(['message' => 'Invalid request!'], ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        return response(['vehicle' => VehicleResource::make($vehicle)], ResponseAlias::HTTP_CREATED);
    }

    // Update existing vehicle
    public function update(Vehicle $vehicle, UpdateVehicleRequest $request) {
        $validated = $request->validated();
        unset($validated['vehicle_image'], $validated['vehicle_specs']);
        $updated = $this->vehicleService->update($vehicle, $validated);

        if (!$updated){
            return response(['message' => 'Update failed!'], ResponseAlias::HTTP_BAD_REQUEST);
        }
        return response(['message' => 'Update successful!'], ResponseAlias::HTTP_OK);

    }

    // Delete vehicle from app
    public function destroy(Vehicle $vehicle) {
        $deleted = $this->vehicleService->destroy($vehicle);
        if (!$deleted){
            return response(['message' => 'Delete failed!'], ResponseAlias::HTTP_BAD_REQUEST);
        }
        return response(['message' => 'Deletion successful!'], ResponseAlias::HTTP_OK);
    }

}
