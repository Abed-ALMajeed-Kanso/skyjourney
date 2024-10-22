<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Access\AuthorizationException;

class ShowUserByIdRequest extends FormRequest
{
    public function authorize()
    {
        // Check if the user is authenticated and has the admin role
        return $this->user() && $this->user()->hasRole('admin');
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
