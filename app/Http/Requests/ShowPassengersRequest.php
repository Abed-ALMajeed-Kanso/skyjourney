<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Access\AuthorizationException;

class ShowPassengersRequest extends FormRequest
{
    public function authorize()
    {
        // Check if the user is authenticated and has 'admin' or 'manager' role
        if (!$this->user() || !($this->user()->hasRole('viewer') || $this->user()->hasRole('admin') || $this->user()->hasRole('manager'))) {
            throw new AuthorizationException('You are not authorized to perform this action.');
        }

        return true; // User is authorized
    }

    public function rules()
    {
        return [
            // 
        ];
    }
}
