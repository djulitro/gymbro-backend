<?php

namespace App\Http\Requests\Subcription;

use Illuminate\Foundation\Http\FormRequest;

class SubcriptionUpdateRequest extends FormRequest
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
            'subcription_duration_id' => 'sometimes|required|integer|exists:\App\Models\SubcriptionDuration,id',
            'name' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|integer',
        ];
    }
}
