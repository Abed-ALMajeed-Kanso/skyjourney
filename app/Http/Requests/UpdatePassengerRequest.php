<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePassengerRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() && ($this->user()->hasRole('admin') || $this->user()->hasRole('manager'));
    }

    public function rules()
    {
        $passengerId = $this->route('id'); // Make sure to get the correct ID from the route

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
