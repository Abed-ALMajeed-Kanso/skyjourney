<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        // Basic validation
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $originalImage = $request->file('image');
            $originalImageName = time() . '_' . $originalImage->getClientOriginalName();

            // Store original image
            $originalImagePath = 'uploads/Images/original/' . $originalImageName;
            $originalImage->storeAs('uploads/Images/original', $originalImageName);

            // Create thumbnail path
            $thumbnailPath = 'uploads/Images/thumbnails/' . $originalImageName;

            // Check if thumbnail already exists
            if (!Storage::exists($thumbnailPath)) {
                // Create thumbnail if it doesn't exist
                $thumbnailImage = Image::make($originalImage->getRealPath());
                $thumbnailImage->resize(150, 150);
                $thumbnailImage->save(storage_path('app/' . $thumbnailPath));
            }

            // Return success response
            return response()->json([
                'original' => url('storage/uploads/Images/original/' . $originalImageName),
                'thumbnail' => url('storage/uploads/Images/thumbnails/' . $originalImageName),
            ]);
        }

        return response()->json(['error' => 'File not uploaded'], 400);
    }
}
