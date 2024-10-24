<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;

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

        // sleep(3);
        
        // $manager = new ImageManager();
        // $thumbnailImageName = time() . '_thumb.jpg';
        
        // $thumbnailImage = $manager->make($originalImage);
        // $thumbnailImage->resize(150, 150);

        // $thumbnailPath = 'uploads/Images/thumbnails/' . $thumbnailImageName; 

        return Storage::disk('s3')->url($thumbnailPath);
    }
}
