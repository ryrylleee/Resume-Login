<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateResumeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // true means anyone who is logged in (thanks to our route middleware)
        // can use this form.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // These are the rules from your validate_data function
        return [
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'profile_summary' => 'required|string',
            'github_link' => 'required|url|max:255',
            'linkedin_link' => 'required|url|max:255',
        ];
    }
}