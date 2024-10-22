<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Access\AuthorizationException;

class UpdatePassengerRequest extends FormRequest
{
    public function authorize()
    {
        // Use the user() method directly to check for the authenticated user
        $user = $this->user();
        return $user && ($user->hasRole('admin') || $user->hasRole('manager')); // Check for admin or manager role
    }

    public function rules()
    {
        $passengerId = $this->route('id'); // Ensure to get the correct ID from the route

        return [
            'flight_id' => 'sometimes|required|exists:flights,id', 
            'last_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:passengers,email,' . $passengerId,
            'password' => 'nullable|string|min:8', 
            'dob' => 'sometimes|required|date',
            'passport_expiry_date' => 'sometimes|required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
