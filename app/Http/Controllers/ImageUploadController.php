<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        Log::info('Upload started');

        // Validate the image
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        Log::info('Validation passed');

        // Store original image
        $originalImage = $request->file('image');
        $originalImageName = time() . '_' . $originalImage->getClientOriginalName();
        $originalImagePath = 'upload/Images/original/' . $originalImageName;

        // Save the original image to the storage/app/upload/Images/original directory
        $originalImage->storeAs('upload/Images/original', $originalImageName);
        Log::info('Original image saved');

        // Create thumbnail
        $thumbnailImage = Image::make($originalImage->getRealPath());
        $thumbnailImage->resize(150, 150); // Resize to thumbnail size

        // Save the thumbnail to the storage/app/upload/Images/thumbnails directory
        $thumbnailPath = 'upload/Images/thumbnails/' . $originalImageName;
        $thumbnailImage->save(storage_path('app/' . $thumbnailPath));
        Log::info('Thumbnail created and saved');

        // Save paths to database or return them in response
        return response()->json([
            'original' => asset('storage/' . $originalImagePath),
            'thumbnail' => asset('storage/' . $thumbnailPath),
        ]);
    }
}
