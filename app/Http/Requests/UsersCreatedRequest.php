<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersCreatedRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'users' => 'required',
            'users.*.email' => 'required|email|unique:users,email',
            'users.*.name' => 'required|string',
            'users.*.iso_code_country' => 'required|string|exists:countries,iso_code',
        ];
    }
}
