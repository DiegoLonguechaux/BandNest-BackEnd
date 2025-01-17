<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('bands', 'name')->ignore($this->band->id),
            ],
            'description' => ['nullable', 'string'],
            'logo' => ['nullable', 'string', 'url', 'max:255'],
            'genres' => ['nullable', 'array'],
            'genres.*' => [Rule::exists('genres', 'id')],
            'users' => ['nullable', 'array'],
            'users.*' => [Rule::exists('users', 'id')],
        ];
    }
}
