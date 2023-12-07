<?php

namespace App\Http\Requests;

use App\Enums\RoleAbility;
use Illuminate\Foundation\Http\FormRequest;

class ViewUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->currentAccessToken()->can(RoleAbility::USER_VIEW->value);
    }
}
