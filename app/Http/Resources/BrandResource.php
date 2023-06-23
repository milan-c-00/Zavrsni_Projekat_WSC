<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($request->is('api/brands')){
            return [
                'id' => $this->id,
                'name' => $this->name,
                'brand_models' => VehicleModelResource::collection($this->brand_models)
            ];
        }
        return [
            'name' => $this->name
        ];

    }
}
