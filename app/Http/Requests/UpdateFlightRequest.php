<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFlightRequest extends FormRequest
{
    public function authorize()
    {
        
        return $this->user() && ($this->user()->hasRole('admin') || $this->user()->hasRole('manager'));
    }

    public function rules()
    {
        $flightId = $this->route('id'); 

        return [
            'number' => 'sometimes|required|string|max:255|unique:flights,number,' . $flightId,
            'departure_city' => 'sometimes|required|string|max:255',
            'arrival_city' => 'sometimes|required|string|max:255',
            'departure_time' => 'sometimes|required|date',
            'arrival_time' => 'sometimes|required|date',
        ];
    }
}
