<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Requests\ShowFlightsRequest;
use App\Http\Requests\ShowFlightByIdRequest;
use App\Http\Requests\ShowPassengerByFlightIdRequest;
use App\Http\Requests\UpdateFlightRequest;
use App\Http\Requests\StoreFlightRequest;

// use App\Http\Requests\DeleteFlightRequest;

class FlightController extends Controller
{
    /**
     * Get all flights with pagination, filtering, and sorting.
     */
    public function index(ShowFlightByIdRequest $request)
    {
        $flights = QueryBuilder::for(Flight::class)
            ->allowedFilters([AllowedFilter::partial('departure_city'), AllowedFilter::partial('arrival_city')])
            ->allowedSorts(['departure_time', 'arrival_time'])
            ->paginate($request->input('per_page', 10));

        return response()->json($flights);
    }

    /**
     * Store a new flight.
     */
    public function store(StoreFlightRequest $request)
    {
        $validatedData = $request->validate([
            'number' => 'required|string|max:255|unique:flights,number',
            'departure_city' => 'required|string|max:255',
            'arrival_city' => 'required|string|max:255',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date',
        ]);

        $flight = Flight::create($validatedData);

        return response()->json($flight, 201);
    }

    /**
     * Show a single flight.
     */
    public function show(ShowFlightByIdRequest $request, $id)
    {
        $flight = Flight::findOrFail($id);
        return response()->json($flight);
    }    

    /**
     * Update a flight's details.
     */
    public function update(UpdateFlightRequest $request, $id)
    {
        // Find the flight by ID or fail
        $flight = Flight::findOrFail($id);

        // The request is already validated by UpdateFlightRequest, so get the validated data
        $validatedData = $request->validated();

        // Update the flight with the validated data
        $flight->update($validatedData);

        // Return the updated flight as a JSON response
        return response()->json($flight);
    }


    /**
     * Delete a flight.
     */
    public function destroy($id)
    {
        $flight = Flight::findOrFail($id);
        $flight->delete();
    
        return response()->json(['message' => 'Flight deleted successfully']);
    }
    

    /**
     * Get passengers for a specific flight.
     */
    public function passengers(ShowPassengerByFlightIdRequest $request, $flightId)
    {
        $flight = Flight::findOrFail($flightId);
        $passengers = $flight->passengers()->paginate(10);
        return response()->json($passengers);
    }
    
}
