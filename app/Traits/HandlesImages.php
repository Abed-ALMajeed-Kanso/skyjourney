<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait HandlesImages
{
    public function storeImage($imageData)
    {

        $image = str_replace('data:image/jpeg;base64,', '', $imageData);
        $image = str_replace(' ', '+', $image);
        $originalImage = base64_decode($image);

        $originalImageName = time() . '_image.jpg';
        $originalImagePath = 'uploads/Images/original/' . $originalImageName;
        Storage::disk('public')->put($originalImagePath, $originalImage);
        
        $thumbnailImageName = time() . '_thumb.jpg';
        // $thumbnailImage = Image::make($originalImage)->resize(150, 150)->encode('jpg');
        $thumbnailImage = $originalImage; 
        $thumbnailPath =  $thumbnailImageName;
        Storage::disk('s3')->put($thumbnailPath, (string) $thumbnailImage); 
        
        return Storage::disk('s3')->url($thumbnailPath);
    }
}
