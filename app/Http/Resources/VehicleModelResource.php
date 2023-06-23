<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleModelResource extends JsonResource
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
                'name' => $this->name
            ];
        }
        return [
            'name' => $this->name
        ];
    }
}
