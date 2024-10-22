<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Access\AuthorizationException;

class StorePassengerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Check if the user is authenticated and has the 'admin' or 'manager' role
        if (!$this->user() || !($this->user()->hasRole('admin') || $this->user()->hasRole('manager'))) {
            throw new AuthorizationException('You are not authorized to perform this action.');
        }

        return true; // User is authorized
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
            'email' => 'required|email|unique:passengers,email',
            'password' => 'required|string|min:8',
            'dob' => 'required|date',
            'passport_expiry_date' => 'required|date|after:today',
            'image' => 'nullable|string',
        ];
    }
}
