<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest; 
use App\Http\Requests\UpdateUserRequest; 
use App\Http\Requests\ShowUsersRequest; 
use App\Http\Requests\ShowUserByIdRequest; 
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedSort;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Imports\DeleteUserRequest;
use Spatie\QueryBuilder\AllowedFilter;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return JsonResponse
     */
    public function index(ShowUsersRequest $request): JsonResponse
    {
        $users = QueryBuilder::for(User::class)
            ->allowedFilters([
                AllowedFilter::partial('name'),
                AllowedFilter::partial('email'),
            ])
            ->allowedSorts(['name', 'email', 'created_at'])
            ->paginate($request->input('per_page', 10));

        return response()->json($users);
    }
    /**
     * Display the specified user.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(ShowUserByIdRequest $request, $id): JsonResponse
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }
    /**
     * Store a newly created user in storage.
     *
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        // Validation is already handled in StoreUserRequest

        // Create the user with hashed password and set additional fields
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(), // Set to now for new users
            'remember_token' => Str::random(10), // Generate a token for new users
        ]);

        return response()->json($user, 201); // Return 201 Created status
    }
    /**
     * Update the specified user in storage.
     *
     * @param UpdateUserRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        // Validation is already handled in UpdateUserRequest

        // Find the user
        $user = User::findOrFail($id);

        // Update password if provided and hash it
        if ($request->filled('password')) {
            $request->merge(['password' => Hash::make($request->password)]);
        }

        // Update user attributes, including email_verified_at and remember_token
        $user->update($request->only('name', 'email', 'password') + [
            'email_verified_at' => $request->email_verified_at ?? now(), // Set to now if not provided
            'remember_token' => $request->remember_token ?? Str::random(10), // Generate token if not provided
        ]);

        return response()->json($user);
    }

    /**
     * Remove the specified user from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $user = User::findOrFail($id); 
        $user->delete(); 
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function import()
    {
        // Specify the path to the CSV file 
        $filePath = storage_path('app/uploads/users.csv');

        // Load the data from the CSV file
        $data = Excel::toArray(new UsersImport, $filePath);

        // Assuming your data is in the first sheet
        return response()->json($data[0]);
    }
}
