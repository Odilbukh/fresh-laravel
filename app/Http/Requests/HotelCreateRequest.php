<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelCreateRequest extends FormRequest
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
            'address' => 'string|max:255',
            'description' => 'string',
            'contact_info' => 'string|max:255',
            'user_ids' => 'array',
            'user_ids.*' => 'integer|exists:users,id',
            'room_ids' => 'array',
            'room_ids.*' => 'integer|exists:rooms,id',
        ];
    }
}
