<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'trailer_url' => 'nullable|url',
            'duration' => 'required|integer|min:1',
            'poster_url' => 'nullable|url',
            'poster_file' => 'nullable|file|mimes:jpeg,png,jpg,webp|max:5120', // Allow up to 5MB
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        \Log::error('Validation Failed:', $validator->errors()->toArray());
        parent::failedValidation($validator);
    }
}
