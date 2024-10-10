<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;

class PassengerController extends Controller
{
    /**
     * Get all passengers with pagination, filtering, and sorting.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Define the base query
        $query = Passenger::query();

        // Apply filters (e.g., by first_name, last_name, email)
        if ($request->has('first_name')) {
            $query->where('first_name', 'like', '%' . $request->input('first_name') . '%');
        }

        if ($request->has('last_name')) {
            $query->where('last_name', 'like', '%' . $request->input('last_name') . '%');
        }

        if ($request->has('email')) {
            $query->where('email', 'like', '%' . $request->input('email') . '%');
        }

        // Sorting (e.g., by first_name, last_name, email)
        if ($request->has('sort_by')) {
            $sortField = $request->input('sort_by');
            $sortOrder = $request->input('sort_order', 'asc'); // Default to ascending order
            $query->orderBy($sortField, $sortOrder);
        }

        // Paginate the results (default to 10 items per page)
        $passengers = $query->paginate($request->input('per_page', 10));

        return response()->json($passengers);
    }
}
