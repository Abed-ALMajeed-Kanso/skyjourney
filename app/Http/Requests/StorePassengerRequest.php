<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePassengerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Only allow access if the user has the 'admin' or 'manager' role
        return $this->user() && ($this->user()->hasRole('admin') || $this->user()->hasRole('manager'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'flight_id' => 'required|exists:flights,id', 
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:passengers,email', // Ensure email is unique in the passengers table
            'password' => 'required|string|min:8', // Ensure password is at least 8 characters
            'dob' => 'required|date', // Date of birth is required
            'passport_expiry_date' => 'required|date|after:today', // Ensure passport expiry date is in the future
            'image' => 'nullable|string', // Accept base64-encoded string for the image
        ];
    }
}
