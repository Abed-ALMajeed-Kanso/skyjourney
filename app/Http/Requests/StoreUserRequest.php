<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth; // Import the Auth facade
use Illuminate\Auth\Access\AuthorizationException;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        // Check if the user is authenticated and has the admin role
        return Auth::check() && Auth::user()->hasRole('admin'); // Use Auth::check() for safety
    }

    protected function failedAuthorization()
    {
        // Throw an AuthorizationException with a custom message
        throw new AuthorizationException('You are not authorized to perform this action.');
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed', // Password confirmation
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.unique' => 'Email must be unique',
            'password.required' => 'Password is required',
            'password.confirmed' => 'Passwords do not match',
        ];
    }
}
