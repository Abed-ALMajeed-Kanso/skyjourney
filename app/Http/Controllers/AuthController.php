<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        // Logout the user to clear all sessions
        Auth::logout();
    
        // Attempt to log in the user with the provided credentials
        if (Auth::attempt($request->only('email', 'password'))) {
            // Regenerate session to prevent session fixation
            $request->session()->regenerate();
    
            // Get the authenticated user
            $user = Auth::user();
    
            // Create a new token for the user
            $token = $user->createToken('YourAppName')->plainTextToken;
    
            // Return the token in the response
            return response()->json(['token' => $token], 200);
        }
    
        // Return failure response if authentication fails
        return response()->json(['message' => 'Unauthorized'], 401);
    }
    

    public function logout(Request $request)
    {
        // Get the token from the 'Authorization' header
        $headerToken = $request->bearerToken(); // Extracts the token from the Authorization header
    
        // Check if the user is authenticated and retrieve their tokens
        $user = $request->user();
    
        // Check if the user has any tokens
        if ($user && $user->tokens()->count() > 0) {
            // Check if the token from the header matches any token stored for this user
            $storedToken = $user->tokens()->where('token', hash('sha256', $headerToken))->first();
    
            if ($storedToken) {
                // Delete the token that matches
                $storedToken->delete();
    
                return response()->json(['message' => 'Successfully logged out']);
            } else {
                // If token doesn't match, return an error
                return response()->json(['message' => 'Invalid token'], 401);
            }
        }
    
        // If no tokens exist or user is not authenticated
        return response()->json(['message' => 'No active session found.'], 404);
    }
    

    
}
