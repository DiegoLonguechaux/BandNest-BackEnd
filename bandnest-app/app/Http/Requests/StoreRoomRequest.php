<?php

namespace App\Http\Requests;

use App\Models\Material;
use App\Models\Structure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoomRequest extends FormRequest
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
            'structure_id' => ['required', Rule::exists(Structure::class, 'id')],
            'name' => ['required', 'string', 'max:255'],
            'size' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'price_per_hour' => ['required', 'numeric', 'min:0'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'zip_code' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:255'],
            'materials' => ['nullable', 'array'],
            'materials.*' => [Rule::exists(Material::class, 'id')]
        ];
    }
}
