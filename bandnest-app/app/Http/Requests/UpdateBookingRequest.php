<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookingRequest extends FormRequest
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
            'user_id' => ['required', Rule::exists('users', 'id')],
            'room_id' => ['required', Rule::exists('rooms', 'id')],
            'band_id' => ['nullable', Rule::exists('bands', 'id')],
            'start' => ['required', 'date', 'after_or_equal:today'],
            'end' => ['required', 'date', 'after:start'],
            'total_price' => ['required', 'numeric', 'min:0'],
            'state' => ['nullable', 'string', Rule::in(['pending', 'confirmed', 'cancelled'])],
        ];
    }
}
