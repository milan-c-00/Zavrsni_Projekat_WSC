<?php

namespace App\Http\Services;

use App\Models\Document;
use Illuminate\Support\Facades\Storage;

class DocumentService
{

    public function storeDocument($file, $vehicle){

        $name = $file->getClientOriginalName();
        $path = "storage/" . $file->store('documents');
        return $vehicle->document()->create([
            'name' => $name,
            'path' => $path
        ]);

    }
    // Delete doc from both database and storage
    public function deleteDocument(Document $document) {
        $document?->delete();
        if($document->path){
            $fileName = basename($document->path);
            Storage::delete('documents/'.$fileName);
        }
    }
}
