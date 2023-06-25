<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Vehicle extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['brand', 'vehicle_model', 'image', 'document'];

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function vehicle_model() {
        return $this->belongsTo(\App\Models\VehicleModel::class);
    }

    public function image(): MorphOne {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function document(): MorphOne {
        return $this->morphOne(Document::class, 'documentable');
    }


}
