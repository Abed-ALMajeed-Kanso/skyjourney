<?php

namespace App\Traits;

use Intervention\Image\ImageManagerStatic as Image;
use Storage;
use Intervention\Image\ImageManager;
use Aws\S3\S3Client;
use Intervention\Image\Drivers\Gd\Driver;

trait DeletePassengerImage
{
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