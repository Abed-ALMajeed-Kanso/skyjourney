<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Facades\Request;

class FlightController extends Controller
{
    public function index(Request $request)
    {
        $flights = QueryBuilder::for(Flight::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('passenger_id'),
                'departure_city', 
                'arrival_city'
            ])
            ->with('passengers')
            ->defaultSort('-updated_at')
            ->allowedSorts(['number', 'departure_time', 'arrival_time', 'created_at', 'updated_at'])
            ->paginate($request->input('per_page', 10));

        return response(['success' => true, 'data' => $flights]);
    }

    public function store(Request $request)
    {
        // Since StoreFlightRequest already validates, we can use the validated data directly
        $validatedData = $request->validated();
    
        // Create the new flight record
        $flight = Flight::create($validatedData);

        return response(['success' => true, 'data' => $flight]);
    }
    

    public function show(Flight $flight)
    {
        $flight->load('passengers');
        return response(['success' => true, 'data' =>$flight]);
    }    

    public function update(Request $request, Flight $flight)
    {
        $validatedData = $request->validate([
            'number' => 'required|string|max:255|unique:flights,number',
            'departure_city' => 'required|string|max:255',
            'arrival_city' => 'required|string|max:255',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date',
        ]);

        $flight->update($validatedData);

        return response(['success' => true, 'data' => $flight]);
    }

    public function destroy(Flight $flight)
    {    
        $flight->delete();
        return response(['success' => true, 'data' => null], Response::HTTP_NO_CONTENT);
    }
}
