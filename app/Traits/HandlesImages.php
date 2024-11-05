<?php

namespace App\Traits;

use Intervention\Image\ImageManagerStatic as Image;
use Storage;
use Intervention\Image\ImageManager;
use Aws\S3\S3Client;
use Intervention\Image\Drivers\Gd\Driver;


trait HandlesImages
{
    public function storeImage($imageData)
    {
        $this->validate(request(), [
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,svg|max:5120',
        ]);

        $uploadedFile = $imageData;
        $originalImageName = time() . '_' . $uploadedFile->getClientOriginalName();
        Storage::disk('public')->putFileAs('uploads/images/original', $uploadedFile, $originalImageName);

        $manager = new ImageManager(new Driver());
        $thumbnail = $manager->read(storage_path('app/public/uploads/images/original/' . $originalImageName));
        
        $thumbnail->resize(375, 250); 
        
        // $thumbnail->resize(400, null, function ($constraint) {
        //     $constraint->aspectRatio();
        //     $constraint->upsize(); 
        // });
        // resizing in other method with other ratio

        $s3Client = new S3Client([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        $thumbnailStream = fopen('php://temp', 'r+'); 
        $thumbnail->encode(); 
        fwrite($thumbnailStream, (string) $thumbnail->encode());
        rewind($thumbnailStream); 

        $result = $s3Client->putObject([
            'Bucket' => env('AWS_BUCKET'),
            'Key' => 'images/thumbnails/' . $originalImageName,
            'Body' => $thumbnailStream,
            'ContentType' => 'image/jpeg', 
        ]);

        fclose($thumbnailStream);
        return $result['ObjectURL'];
    }
    public function deleteImage($passenger)
    {
        if ($passenger->image) {
            $s3Client = new S3Client([
                'region' => env('AWS_DEFAULT_REGION'),
                'version' => 'latest',
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);
    
            $imageKey = str_replace(env('AWS_URL'), '', $passenger->image);
    
            $s3Client->headObject([
                'Bucket' => env('AWS_BUCKET'),
                'Key' => $imageKey,
            ]);
    
            $s3Client->deleteObject([
                'Bucket' => env('AWS_BUCKET'),
                'Key' => $imageKey,
            ]);
    
            $passenger->image = '';
            $passenger->save();
        }
    }    
}

    