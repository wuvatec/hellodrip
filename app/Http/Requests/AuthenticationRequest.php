<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthenticationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {

        $rules = [];

        if ($this->getRequestUri() ==  '/v1/register') {
            $rules['name']      = ['bail', 'required', 'min:8'];
            $rules['email']     = ['bail', 'required', 'email', 'unique:users'];
            $rules['password']  = ['bail', 'required', 'min:8'];
            $rules['active']    = '';
        }

        if ($this->getRequestUri() == '/v1/login') {
            $rules['email']  = ['bail', 'required', 'email'];
            $rules['password']  = ['bail', 'required', 'min:8'];
        }

        return $rules;

    }

    public function messages(): array
    {
        return [
            'name.required'         => 'Name is required to register an account',
            'name.min:8'            => 'The name must not be less then 8 characters',
            'email.required'        => 'A valid email address is required',
            'email.email'           => 'A valid email address is required',
            'email.unique:users'    => 'Email address already exist',
            'password.required'     => 'Password value can not be empty',
            'password.min:8'        => 'Password can not be less then 8 characters',
        ];
    }
}
