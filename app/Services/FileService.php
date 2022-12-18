<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\File;

class FileService {
    public static function upload(Request $request, $object, $fileableId, $fileableType, $path) {
        if (!$request->hasFile('file')) {
            return false;
        }

        $pathUpload = 'storage/' . $path;
        $file = $request->file;
        $fileName = $file->hashName();

        // In case create
        if (empty($object)) {
            $create = File::create([
                'path' => $pathUpload,
                'file_name' => $fileName,
                'category' => 'Image',
                'fileable_id' => $fileableId,
                'fileable_type' => $fileableType,
            ]);
        } 
        // In case update
        else {
            // Remove old file
            if (Storage::disk('public')->exists($path . $object->file_name)) {
                Storage::disk('public')->delete($path . $object->file_name);
            }

            // Update database
            $object->file_name = $fileName;
            $object->save();
        }

        $path = $file->store($path, 'public');

        return $path;
    }
}