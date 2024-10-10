<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    /**
     * Get all flights with pagination, filtering, and sorting.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Define the base query
        $query = Flight::query();

        // Apply filters (e.g., by departure_city, arrival_city)
        if ($request->has('departure_city')) {
            $query->where('departure_city', 'like', '%' . $request->input('departure_city') . '%');
        }

        if ($request->has('arrival_city')) {
            $query->where('arrival_city', 'like', '%' . $request->input('arrival_city') . '%');
        }

        // Sorting (e.g., by departure_time, arrival_time)
        if ($request->has('sort_by')) {
            $sortField = $request->input('sort_by');
            $sortOrder = $request->input('sort_order', 'asc'); // Default to ascending order
            $query->orderBy($sortField, $sortOrder);
        }

        // Paginate the results (default to 10 items per page)
        $flights = $query->paginate($request->input('per_page', 10));

        return response()->json($flights);
    }

    public function passengers($flightId)
    {
        // Find the flight by ID
        $flight = Flight::findOrFail($flightId);
    
        // Retrieve passengers for the flight
        $passengers = $flight->passengers()->paginate(10);  // Paginate if needed
    
        return response()->json($passengers);
    }
    

}
