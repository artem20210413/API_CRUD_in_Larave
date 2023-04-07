<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LabelsRequest extends FormRequest
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
            'Labels' => 'required|array',
            'Labels.*' => 'required|string|max:100|min:5',
        ];
    }
}
