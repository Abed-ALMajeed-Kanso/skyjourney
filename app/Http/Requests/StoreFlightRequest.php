<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFlightRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user() && ($this->user()->hasRole('admin') || $this->user()->hasRole('manager'));
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
