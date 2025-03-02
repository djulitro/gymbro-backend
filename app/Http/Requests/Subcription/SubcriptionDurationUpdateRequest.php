<?php

namespace App\Http\Requests\Subcription;

use Illuminate\Foundation\Http\FormRequest;

class SubcriptionDurationUpdateRequest extends FormRequest
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
            'name' => 'sometimes|required|string',
            'description' => 'sometimes|required|integer',
            'day_durations' => 'sometimes|required|integer',
        ];
    }
}
