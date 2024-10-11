<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        // Check if the user is authenticated and has the admin role
        return Auth::user() && Auth::user()->hasRole('admin');
    }

    protected function failedAuthorization()
    {
        // Throw an AuthorizationException with a custom message
        throw new AuthorizationException('You are not authorized to perform this action.');
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $this->route('id'), // Ensure the email is unique except for the current user
            'password' => 'nullable|string|min:8|confirmed', // Password is optional on update, must be confirmed if provided
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.unique' => 'Email must be unique',
            'password.confirmed' => 'Passwords do not match',
        ];
    }
}
