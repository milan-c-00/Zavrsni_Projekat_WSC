<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $with = ['brand_models'];

    public function vehicles() {
        return $this->hasMany(Vehicle::class);
    }

    public function brand_models() {
        return $this->hasMany(\App\Models\VehicleModel::class);
    }

}
