<?php

namespace App\Http\Requests;

use App\Enums\RoleAbility;
use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PatchTempleMemberRolesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->currentAccessToken()->canAny(RoleAbility::USER_UPDATE->value, RoleAbility::USER_UPDATE->value.':'.$this->temple->_id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'roles' => 'required|array',
            'roles.*' => [
                'nullable',
                'distinct',
                Rule::exists(Role::class, 'role')->where('temple._id', $this->temple->_id)
            ]
        ];
    }
}
