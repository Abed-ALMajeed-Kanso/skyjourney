<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Response;

class SessionController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users', 
            'password' => 'required|string|min:8|confirmed', 
        ]);

        $user = User::create($validatedData);
        $validatedData['password'] = Hash::make($validatedData['password']); 
        $user->assignRole('viewer');
        
        return response(['success' => true, 'data' => $user], Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {

            $user->tokens()->delete();
            $token = $user->createToken('YourAppName')->plainTextToken;
            $user->token = $token;
            return response([
                'success' => true,
                'data' => $user->token,
            ], Response::HTTP_OK);

        }
        return response([
            'success' => false,
            'message' => 'Unauthorized',
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user) {

            $user->tokens()->delete();
            return response([
                'success' => true,
                'message' => 'Successfully logged out',
            ], Response::HTTP_OK);
        }
        return response([
            'success' => false,
            'message' => 'No active session found',
        ], Response::HTTP_NOT_FOUND);
    }
}