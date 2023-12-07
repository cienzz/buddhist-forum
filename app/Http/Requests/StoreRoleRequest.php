<?php

namespace App\Http\Requests;

use App\Enums\RoleAbility;
use App\Models\Temple;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->currentAccessToken()->canAny(RoleAbility::ROLE_CREATE->value, RoleAbility::ROLE_CREATE->value.':'.$this->temple_id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if (! $this->temple_id && $this->user()->currentAccessToken()->can(RoleAbility::ROLE_CREATE->value)) {
            $abilities = RoleAbility::cases();
        } else {
            $abilities = RoleAbility::private();
        }
        
        return [
            'temple_id' => Rule::exists(Temple::class, '_id'),
            'role' => 'required|string|min:3|max:25',
            'abilities' => 'array',
            'abilities.*' => Rule::in($abilities)
        ];
    }
}
