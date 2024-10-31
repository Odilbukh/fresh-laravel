<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'middle_name' =>'string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4|max:8',
            'birthday' => 'date|date_format:Y-m-d|nullable',
            'avatar' => 'nullable',
            'phone' => 'nullable|max:15'
        ];
    }
}