<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPatchPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:6|max:15|confirmed|different:current_password'
        ];
    }
}
