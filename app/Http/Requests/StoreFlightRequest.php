<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Access\AuthorizationException;

class StoreFlightRequest extends FormRequest
{
    public function authorize()
    {
        // Check if the user is authenticated and has 'admin' or 'manager' role
        if (!$this->user() || !($this->user()->hasRole('admin') || $this->user()->hasRole('manager'))) {
            throw new AuthorizationException('You are not authorized to perform this action.');
        }

        return true; // User is authorized
    }

    public function rules()
    {
        return [
            'number' => 'required|string|max:255|unique:flights,number',
            'departure_city' => 'required|string|max:255',
            'arrival_city' => 'required|string|max:255',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date',
        ];
    }
}
