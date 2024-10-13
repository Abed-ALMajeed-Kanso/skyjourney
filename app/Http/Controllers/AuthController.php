<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Passenger;

class AuthController extends Controller
{
    // Login for normal users
    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to find the user by email
        $user = User::where('email', $request->email)->first();

        // If the user exists and the password matches
        if ($user && Hash::check($request->password, $user->password)) {
            // Clear all existing tokens for this user (if needed)
            $user->tokens()->delete();

            // Generate a new Sanctum token
            $token = $user->createToken('YourAppName')->plainTextToken;

            // Return the token in the response
            return response()->json(['token' => $token], 200);
        }

        // Return unauthorized response if authentication fails
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    // Logout for normal users
    public function logout(Request $request)
    {
        // Get the authenticated user
        $user = $request->user();

        if ($user) {
            // Revoke all tokens for the user
            $user->tokens()->delete();

            return response()->json(['message' => 'Successfully logged out']);
        }

        return response()->json(['message' => 'No active session found'], 404);
    }

    // Login for passengers
    public function login_passenger(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to find the passenger by email
        $passenger = Passenger::where('email', $request->email)->first();

        // If the passenger exists and the password matches
        if ($passenger && Hash::check($request->password, $passenger->password)) {
            // Clear all existing tokens for this passenger (if needed)
            $passenger->tokens()->delete();

            // Generate a new Sanctum token
            $token = $passenger->createToken('PassengerApp')->plainTextToken;

            // Return the token in the response
            return response()->json(['token' => $token], 200);
        }

        // Return unauthorized response if authentication fails
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    // Logout for passengers
    public function logout_passenger(Request $request)
    {
        $passenger = $request->user(); // This should be set by the middleware
    
        if ($passenger) {
            $passenger->tokens()->delete(); // Deletes all tokens for the user
            return response()->json(['message' => 'Successfully logged out']);
        }
    
        return response()->json(['message' => 'No active session found'], 404);
    }
    
}