<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['brand', 'vehicle_model'];

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function vehicle_model() {
        return $this->belongsTo(\App\Models\VehicleModel::class);
    }


}
