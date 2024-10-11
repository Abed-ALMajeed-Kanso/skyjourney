<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest; 
use App\Http\Requests\UpdateUserRequest; 
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = User::all(); // Retrieve all users
        return response()->json($users);
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
     * Display the specified user.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user = User::findOrFail($id); // Find the user or fail
        return response()->json($user);
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
}
