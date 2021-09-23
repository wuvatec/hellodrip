<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required',
        ];

        switch ($this->method()) {
            case 'GET':
            case 'DELETE':  {
               return [];
            }
            case 'POST': {
                $rules['email'] = 'bail|required|email|unique:users';
                $rules['password'] = 'required';
            }
            case 'PATCH':
            case 'PUT': {
                $rules['email'] = ['bail', 'required', 'email', Rule::unique('users')->ignore($this->user()->id,  'id')];
            }
        }

        return $rules;
    }
}
