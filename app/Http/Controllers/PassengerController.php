<?php

namespace App\Http\Controllers;


use Intervention\Image\Facades\Image;
use App\Models\Passenger;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class PassengerController extends Controller
{
    public function index(Request $request)
    {
        $passengers = QueryBuilder::for(Passenger::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('passenger_id'),
                'first_name', 
                'last_name', 
                'email'
            ])
            ->defaultSort('-updated_at')
            ->allowedSorts(['first_name', 'last_name', 'email', 'created_at', 'updated_at'])
            ->paginate($request->input('per_page', 10));

        return response(['success' => true, 'data' => $passengers], Response::HTTP_OK);
    }

    public function show(Passenger $passenger)
    {
        return response(['success' => true, 'data' => $passenger], Response::HTTP_OK);
    }

    public function store(Request $request)
    {        
        $validatedData = $request->validate([
            'flight_id' => 'required|exists:flights,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:passengers',
            'password' => 'nullable|string|min:8',
            'dob' => 'required|date',
            'passport_expiry_date' => 'required|date',
        ]);
    
        if ($request->has('image')) {
            $imageData = $request->input('image');
            $image = str_replace('data:image/jpeg;base64,', '', $imageData);
            $image = str_replace(' ', '+', $image);
            $originalImage = base64_decode($image);
    
            $originalImageName = time() . '_image.jpg';
            $originalImagePath = 'uploads/Images/original/' . $originalImageName;
            Storage::disk('public')->put($originalImagePath, $originalImage);
     
            //$thumbnailImage = \Intervention\Image\Facades\Image::make($originalImage)->resize(150, 150)->encode('jpg');
           // $thumbnailImage = Image::make($originalImage)->resize(150, 150)->encode('jpg');//l package mestaamela ghalat w akid mana meshye eendak
            $thumbnailImage = $originalImageName;

            $thumbnailImageName = time() . '_thumb.jpg';
            $thumbnailPath = 'uploads/Images/thumbnails/' . $thumbnailImageName;
            Storage::disk('s3')->put($thumbnailPath, (string) $thumbnailImage);  
    
            $validatedData['image'] = Storage::disk('s3')->url($thumbnailPath);
        }
    
        $validatedData['password'] = Hash::make($validatedData['password']);
        $passenger = Passenger::create($validatedData);
    
        return response(['success' => true, 'data' => $passenger], Response::HTTP_CREATED);
    }
    
    
    public function update(Request $request, Passenger $passenger)
    {
        $validatedData = $request->validate([
            'flight_id' => 'required|exists:flights,id',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:passengers',
            'password' => 'nullable|string|min:8',
            'dob' => 'required|date',
            'passport_expiry_date' => 'required|date',
        ]);
    
        if ($request->has('image')) {
            if ($passenger->image) {
                Storage::disk('public')->delete($passenger->image);
            }
            if ($passenger->thumbnail) {
                Storage::disk('s3')->delete(parse_url($passenger->thumbnail, PHP_URL_PATH));
            }
    
            $imageData = $request->input('image');
            $image = str_replace('data:image/jpeg;base64,', '', $imageData);
            $image = str_replace(' ', '+', $image);
            $originalImage = base64_decode($image);
    
            $originalImageName = time() . '_image.jpg';
            $originalImagePath = 'uploads/Images/original/' . $originalImageName;
            Storage::disk('public')->put($originalImagePath, $originalImage);
    
            $thumbnailImage = Image::make($originalImage)->resize(150, 150)->encode('jpg');
            $thumbnailImageName = time() . '_thumb.jpg';
            $thumbnailPath = 'uploads/Images/thumbnails/' . $thumbnailImageName;
            Storage::disk('s3')->put($thumbnailPath, (string) $thumbnailImage);
    
            $validatedData['image'] = $originalImagePath;
            $validatedData['thumbnail'] = Storage::disk('s3')->url($thumbnailPath);
        }
        
        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($request->input('password'));
        }
    
        $passenger->update($validatedData);
    
        return response(['success' => true, 'data' => $passenger]);
    }

    public function destroy(Passenger $passenger)
    {
        if ($passenger->image) {
            Storage::disk('public')->delete($passenger->image);
        }
        if ($passenger->thumbnail) {
            Storage::disk('s3')->delete(parse_url($passenger->image));
        }

        $passenger->delete();

        return response(['success' => true, 'data' => null], Response::HTTP_NO_CONTENT);    
    }
}
