<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;
use App\Http\Requests\ShowPassengersRequest;
use App\Http\Requests\ShowPassengerByIdRequest;
use App\Http\Requests\StorePassengerRequest;
use App\Http\Requests\UpdatePassengerRequest;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class PassengerController extends Controller
{
    /**
     * Get all passengers with pagination, filtering, and sorting.
     */
    public function index(ShowPassengersRequest $request): JsonResponse
    {
        $passengers = QueryBuilder::for(Passenger::class)
            ->allowedFilters([
                AllowedFilter::partial('first_name'), 
                AllowedFilter::partial('last_name'), 
                AllowedFilter::partial('email')
            ])
            ->allowedSorts(['first_name', 'last_name', 'email'])
            ->paginate($request->input('per_page', 10));

        return response()->json($passengers);
    }

    /**
     * Show a single passenger.
     */
    public function show(ShowPassengerByIdRequest $request, $id): JsonResponse
    {
        $passenger = Passenger::findOrFail($id);
        return response()->json($passenger);
    }

    /**
     * Store a new passenger.
     */
    public function store(StorePassengerRequest $request): JsonResponse
    {
        // The validation is already handled by StorePassengerRequest, so no need to validate again.
        $validatedData = $request->validated();
    
        // Hash the password before saving
        $validatedData['password'] = bcrypt($validatedData['password']);
    
        // Create a new passenger record, which must include 'flight_id'
        $passenger = Passenger::create($validatedData);
    
        return response()->json($passenger, 201);
    }
    

    
    


    /**
     * Update a passenger's details.
     */
    public function update(UpdatePassengerRequest $request, $id)
    {
        $passenger = Passenger::findOrFail($id); // Make sure the ID is correct
    
        // Validate the incoming JSON data
        $validatedData = $request->validate([
            'flight_id' => 'sometimes|required|exists:flights,id',
            'last_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:passengers,email,' . $id,
            'password' => 'nullable|string|min:8',
            'dob' => 'sometimes|required|date',
            'passport_expiry_date' => 'sometimes|required|date',
        ]);
    
        // Handle image upload if present in JSON
        if ($request->has('image')) {
            // Optionally delete old images if needed
            if ($passenger->image) {
                Storage::disk('public')->delete($passenger->image); // Delete local image
            }
            if ($passenger->thumbnail) {
                Storage::disk('s3')->delete(parse_url($passenger->thumbnail, PHP_URL_PATH)); // Delete thumbnail from S3
            }
    
            // Decode the base64 image
            $imageData = $request->input('image'); // Assuming the image comes as base64
            $image = str_replace('data:image/jpeg;base64,', '', $imageData);
            $image = str_replace(' ', '+', $image);
            $originalImage = base64_decode($image);
    
            // Store the original image locally
            $originalImageName = time() . '_image.jpg';
            $originalImagePath = 'uploads/Images/original/' . $originalImageName;
            Storage::disk('public')->put($originalImagePath, $originalImage);
    
            // Create a thumbnail and store it on S3
            $thumbnailImage = Image::make($originalImage)->resize(150, 150)->encode('jpg');
            $thumbnailImageName = time() . '_thumb.jpg';
            $thumbnailPath = 'uploads/Images/thumbnails/' . $thumbnailImageName;
            Storage::disk('s3')->put($thumbnailPath, (string) $thumbnailImage);
    
            // Store the new image paths in the database
            $validatedData['image'] = $originalImagePath; // Local storage path
            $validatedData['thumbnail'] = Storage::disk('s3')->url($thumbnailPath); // S3 URL
        }
    
        // Hash the password if provided
        if ($request->filled('password')) {
            $validatedData['password'] = bcrypt($request->input('password'));
        }
    
        // Update the passenger record
        $passenger->update($validatedData);
    
        return response()->json($passenger, 200); // Returning updated passenger data with a 200 status
    }



    /**
     * Delete a passenger.
     */
    public function destroy($id)
    {
        $passenger = Passenger::findOrFail($id);
        
        // Delete images from storage
        if ($passenger->image) {
            Storage::disk('public')->delete($passenger->image); // Delete local image
        }
        if ($passenger->thumbnail) {
            Storage::disk('s3')->delete(parse_url($passenger->thumbnail, PHP_URL_PATH)); // Delete thumbnail from S3
        }

        $passenger->delete();

        return response()->json(['message' => 'Passenger deleted successfully']);
    }
}
