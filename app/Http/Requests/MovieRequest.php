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
            'poster_url' => ['required', 'regex:/^(https?:\/\/|\/).+\.(jpg|jpeg|png|gif|webp)$/i'],
            'trailer_url' => 'nullable|url',
            'duration' => 'required|integer|min:1|max:300', // Added max limit
        ];
    }

    public function passedValidation()
    {
        \Log::info('Validated Data:', $this->validated());
    }
}
