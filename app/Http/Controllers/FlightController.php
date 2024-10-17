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
use Illuminate\Http\JsonResponse;

class FlightController extends Controller
{
    /**
     * Get all flights with pagination, filtering, and sorting.
     */
    public function index(Request $request)
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
        // Since StoreFlightRequest already validates, we can use the validated data directly
        $validatedData = $request->validated();
    
        // Create the new flight record
        $flight = Flight::create($validatedData);
    
        // Return the newly created flight record with a 201 status code
        return response()->json([
            'message' => 'Flight created successfully',
            'flight' => $flight,
        ], 201);
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
        $flight = Flight::findOrFail($id);
        $validatedData = $request->validated();
        $flight->update($validatedData);
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
