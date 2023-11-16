<?php

namespace App\Http\Requests;

use App\Enums\BankCode;
use App\Enums\TempleStatus;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTempleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:5|max:250',
            'description' => 'nullable|string',
            'status' => Rule::in(TempleStatus::cases()),
            'phone_numbers' => 'nullable|array',
            'phone_numbers.*' => 'nullable|string',
            'emails' => 'nullable|array',
            'emails.*' => 'nullable|string',
            'website_url' => 'nullable|url',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string|min:3|max:20',
            'open_times' => 'nullable|array',
            'open_times.*.day' => Rule::in(Carbon::getDays()),
            'open_times.*.hours' => 'nullable|array',
            'open_times.*.hours.0' => 'nullable|date_format:H:i',
            'open_times.*.hours.1' => 'nullable|date_format:H:i',
            'addresses' => 'nullable|array',
            'addresses.*.url' => 'nullable|url',
            'addresses.*.street' => 'nullable|string',
            'addresses.*.city' => 'nullable|string',
            'addresses.*.province' => 'nullable|string',
            'addresses.*.country' => 'nullable|string',
            'addresses.*.note' => 'nullable|string',
            'social_medias' => 'nullable|array',
            'banks' => 'nullable|array',
            'banks.*.code' => Rule::in(BankCode::cases()),
            'banks.*.account_name' => 'string',
            'banks.*.account_number' => 'string',
        ];
    }
}
