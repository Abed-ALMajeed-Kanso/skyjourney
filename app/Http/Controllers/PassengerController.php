<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter; 
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Traits\HandlesImages;
use Illuminate\Support\Facades\Cache;

// add data caching in route and middlware for 5 minutes 
class PassengerController extends Controller
{
    use HandlesImages;
    public function index(Request $request)
    {
        $cacheKey = 'passengers_' . md5(serialize($request->all()));
        $passengers = Cache::remember($cacheKey, 300, function () use ($request) {
            return QueryBuilder::for(Passenger::class)
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
        });
    
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
            'dob' => 'required|date',
            'passport_expiry_date' => 'required|date',
        ]);
    
        if ($request->hasFile('image')) { 
            $validatedData['image'] = $this->storeImage($request->file('image'));
        }

        $passenger = Passenger::create($validatedData);
    
        return response(['success' => true, 'data' => $passenger], Response::HTTP_CREATED);
    }
    
    public function update(Request $request, Passenger $passenger)
    {
        $validatedData = $request->validate([
            'flight_id' => 'required|exists:flights,id',
            'first_name' => 'required|string|max:255',
            'last_name'=> 'required|string|max:255',
            'email' => 'required|email|unique:passengers,email,' . $passenger->id,
            'dob' => 'required|date',
            'passport_expiry_date' => 'required|date',
        ]);

        if ($request->hasFile('image')) { 
            if ($passenger->image)
                $this->deleteImage($passenger);
             $validatedData['image'] = $this->storeImage($request->file('image'));
        }
        
        $passenger->update($validatedData);

        return response(['success' => true, 'data' => $passenger], Response::HTTP_OK);
    }

    public function destroy(Passenger $passenger)
    {
        $passenger->delete();
        return response(['success' => true, 'data' => null], Response::HTTP_NO_CONTENT);
    }
}
