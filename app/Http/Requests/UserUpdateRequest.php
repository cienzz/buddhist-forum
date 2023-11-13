<?php

namespace App\Http\Requests;

use App\Enums\UserGender;
use App\Enums\UserStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'gender'            => Rule::in(UserGender::cases()),
            'birth_at'          => 'date',
            'address'           => 'array',
            'address.city'      => 'string',
            'address.province'  => 'string',
            'address.country'   => 'string',
        ];
    }
}
