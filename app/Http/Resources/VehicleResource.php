<?php

namespace App\Http\Resources;

use App\Models\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'brand_id' => $this->brand_id,
            'vehicle_model_id' => $this->vehicle_model_id,
            'year' => $this->year,
            'price' => $this->price,
            'fuel' => $this->fuel,
            'color' => $this->color,
            'doors' => $this->doors,
            'description' => $this->description,
            'brand' => BrandResource::make($this->brand),
            'vehicle_model' => VehicleModelResource::make($this->vehicle_model)
        ];
    }
}
