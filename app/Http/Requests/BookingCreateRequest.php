<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingCreateRequest extends FormRequest
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
            'user_id' => 'integer|exists:users,id',
            'hotel_id' => 'required|integer|exists:hotels,id',
            'rooms' => 'required|array',
            'rooms.*' => 'integer|exists:rooms,id',
            'guests' => 'required|integer|between:1,100',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date'
        ];
    }
}
