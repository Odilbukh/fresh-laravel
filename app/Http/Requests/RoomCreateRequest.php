<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomCreateRequest extends FormRequest
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
            'hotel_id'=>'required|exists:hotels,id',
            'name' => 'required|string',
            'type' => 'required|string',
            'beds' => 'required|integer',
            'price_per_night' => 'required|numeric',
            'description' => 'required|string',
        ];
    }
}
