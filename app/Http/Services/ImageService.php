<?php

namespace App\Http\Services;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageService
{

    public function storeImage($file, $vehicle){

        $name = $file->getClientOriginalName();
        $path = "storage/" . $file->store('images');
        return $vehicle->image()->create([
            'name' => $name,
            'path' => $path
        ]);

    }

    // Delete image from both database and storage
    public function deleteImage(Image $image) {
        $image?->delete();
        if($image->path){
            $fileName = basename($image->path);
            Storage::delete('images/'.$fileName);
        }
    }

}
