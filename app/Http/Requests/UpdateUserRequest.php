<?php

namespace App\Http\Requests;

use App\Enums\RoleAbility;
use App\Enums\UserGender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user() || $this->user()->currentAccessToken()->canAny(RoleAbility::USER_UPDATE->value);
    }
    
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
