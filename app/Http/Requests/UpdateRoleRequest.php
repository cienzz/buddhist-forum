<?php

namespace App\Http\Requests;

use App\Enums\RoleAbility;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->currentAccessToken()->canAny(RoleAbility::ROLE_UPDATE->value, RoleAbility::ROLE_UPDATE->value.':'.$this->role->temple['_id']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if (! isset($this->role->temple['_id']) && $this->user()->currentAccessToken()->can(RoleAbility::ROLE_UPDATE->value)) {
            $abilities = RoleAbility::cases();
        } else {
            $abilities = RoleAbility::private();
        }
        
        return [
            'abilities' => 'array',
            'abilities.*' => Rule::in($abilities)
        ];
    }
}
