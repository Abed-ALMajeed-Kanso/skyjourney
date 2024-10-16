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
            'flight_id' => 'required|exists:flights,id', // Ensures flight exists in the flights table
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:passengers,email',
            'password' => 'required|string|min:8', // Password must be at least 8 characters long
            'dob' => 'required|date', // Date of birth is required
            'passport_expiry_date' => 'required|date|after:today', // Passport expiry date must be in the future
            'image' => 'nullable|string', // Accept base64 encoded string instead of file upload
        ];
    }
}
