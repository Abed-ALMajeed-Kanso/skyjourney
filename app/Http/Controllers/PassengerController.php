<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Response;

class PassengerController extends Controller
{
    public function index(Request $request)
    {
        $passengers = QueryBuilder::for(Passenger::class)
            ->allowedFilters([
                // id extrac
                // flight id exact
                'first_name', 
                'last_name', 
                'email'
            ])
            ->allowedSorts(['first_name', 'last_name', 'email', 'created_at', 'updated_at'])
            ->paginate($request->input('per_page', 10));

        return response(['success' => true, 'data' => $passengers]);
    }

    public function show(Passenger $passenger)
    {
        return response(['success' => true, 'data' => $passenger]);
    }

    public function store(Request $request)
    {        
        $validatedData = $request->validate([
            'flight_id' => 'sometimes|required|exists:flights,id',
            'last_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:passengers,email',
            'password' => 'nullable|string|min:8',
            'dob' => 'sometimes|required|date',
            'passport_expiry_date' => 'sometimes|required|date',
        ]);

        // ht validition hun w kel shi requests class mahihun
        $validatedData = $request->validated();
    
        //here badel ma tht kel shi bel code u should do a filetrait, btht fi your methods w btestaamlo hun
        if (isset($validatedData['image'])) {
            $imageData = $validatedData['image'];
            $image = str_replace('data:image/jpeg;base64,', '', $imageData);
            $image = str_replace(' ', '+', $image);
            $originalImage = base64_decode($image);
    
            $originalImageName = time() . '_image.jpg';
            $originalImagePath = 'uploads/Images/original/' . $originalImageName;
            Storage::disk('public')->put($originalImagePath, $originalImage);
    
            $thumbnailImage = Image::make($originalImage)->resize(150, 150)->encode('jpg');//l package mestaamela ghalat w akid mana meshye eendak, should check the docs instead of using chatgpt
            $thumbnailImageName = time() . '_thumb.jpg';
            $thumbnailPath = 'uploads/Images/thumbnails/' . $thumbnailImageName;
            Storage::disk('s3')->put($thumbnailPath, (string) $thumbnailImage);//??
    
            $validatedData['image'] = $originalImagePath;
            $validatedData['thumbnail'] = Storage::disk('s3')->url($thumbnailPath);
        }
    
        $validatedData['password'] = bcrypt($validatedData['password']);//dont have password
    
        $passenger = Passenger::create($validatedData);
    
        return response(['success' => true, 'data' => $passenger]);
    }
    
    public function update(Request $request, Passenger $passenger)
    {
        $validatedData = $request->validate([
            'flight_id' => 'sometimes|required|exists:flights,id',
            'last_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:passengers,email',//here l unique rule ghalat
            'password' => 'nullable|string|min:8',
            'dob' => 'sometimes|required|date',
            'passport_expiry_date' => 'sometimes|required|date',
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
            Storage::disk('s3')->delete(parse_url($passenger->thumbnail, PHP_URL_PATH));//???
        }

        $passenger->delete();

        return response(['success' => true, 'data' => null], Response::HTTP_NO_CONTENT);    
    }
}
