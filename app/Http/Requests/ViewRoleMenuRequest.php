<?php

namespace App\Http\Requests;

use App\Enums\RoleAbility;
use App\Models\Temple;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ViewRoleMenuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->currentAccessToken()->canAny(RoleAbility::ROLE_VIEW->value, RoleAbility::ROLE_VIEW->value.':'.$this->temple_id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'temple_id' => [
                ! $this->user()->currentAccessToken()->can(RoleAbility::ROLE_VIEW->value) ? 'required' : 'nullable', 
                Rule::exists(Temple::class, '_id')
            ]
        ];
    }
}
