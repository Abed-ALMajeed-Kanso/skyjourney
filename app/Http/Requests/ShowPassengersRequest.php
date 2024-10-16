<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowPassengersRequest extends FormRequest
{
    public function authorize()
    {
        // Allow all authenticated users
        return $this->user() && ($this->user()->hasRole('viewer') || $this->user()->hasRole('manager') || $this->user()->hasRole('admin'));;
    }

    public function rules()
    {
        return [
            // 
        ];
    }
}
