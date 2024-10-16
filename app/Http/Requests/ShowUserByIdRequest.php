<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowUserByIdRequest extends FormRequest
{
    public function authorize()
    {
        // Allow all authenticated admins
        return $this->user() && $this->user()->hasRole('admin');
    }

    public function rules()
    {
        return [
            'id' => 'required|exists:users,id', 
        ];
    }
}
