<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image; // Use this for image processing
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Store original image
        $originalImage = $request->file('image');
        $originalPath = 'images/original/';
        $originalImageName = time() . '_' . $originalImage->getClientOriginalName();
        $originalImage->move(public_path($originalPath), $originalImageName);

        // Create thumbnail
        $thumbnailPath = 'images/thumbnails/';
        $thumbnailImage = Image::make($originalImage->getRealPath());
        $thumbnailImage->resize(150, 150); // Resize to thumbnail size
        $thumbnailImage->save(public_path($thumbnailPath) . $originalImageName);

        // Save paths to database or return them in response
        return response()->json([
            'original' => asset($originalPath . $originalImageName),
            'thumbnail' => asset($thumbnailPath . $originalImageName),
        ]);
    }
}
