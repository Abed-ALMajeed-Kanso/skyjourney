<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

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

        return response(['success' => true, 'data' => $flights], Response::HTTP_OK);
    }

    public function show(Flight $flight)
    {
        $flight = $flight->load('passengers');
        return response(['success' => true, 'data' => $flight], Response::HTTP_OK);
    }  
    
    public function store(Request $request) 
    {
        $validatedData = $request->validate([
            'number' => 'required|string|max:255|unique:flights', 
            'departure_city' => 'required|string|max:255',
            'arrival_city' => 'required|string|max:255',
            'departure_time' => 'required|date_format:Y-m-d H:i:s|after_or_equal:now', 
            'arrival_time' => 'required|date_format:Y-m-d H:i:s|after:departure_time', 
        ]);
    
        $flight = Flight::create($validatedData);

        return response(['success' => true, 'data' => $flight], Response::HTTP_CREATED);
    }

    public function update(Request $request, Flight $flight)
    {
        $validatedData = $request->validate([
            'number' => 'required|string|max:255|unique:flights,number,' . $flight->id,
            'departure_city' => 'required|string|max:255',
            'arrival_city' => 'required|string|max:255',
            'departure_time' => 'required|date_format:Y-m-d H:i:s|after_or_equal:now', 
            'arrival_time' => 'required|date_format:Y-m-d H:i:s|after:departure_time', 
        ]);

        $flight->update($validatedData);

        return response(['success' => true, 'data' => $flight], Response::HTTP_OK);
    }

    public function destroy(Flight $flight)
    {
        $flight->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
