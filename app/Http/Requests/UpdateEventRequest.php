<?php

namespace App\Http\Requests;

use App\Enums\EventParticipationConditionType;
use App\Enums\EventStatus;
use App\Enums\RoleAbility;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->currentAccessToken()->canAny(RoleAbility::EVENT_UPDATE->value, RoleAbility::EVENT_UPDATE->value.':'.$this->temple_id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|min:5|max:250',
            'description' => 'string',
            'cover_image_url' => 'url',
            'cover_image' => [
                'file', 
                'mimes:jpeg,png,gif,bmp,webp,ico', 
                function ($attribute, $value, $fail) {
                    $finfo = new \finfo(FILEINFO_MIME_TYPE);
                    $mime = $finfo->file($value);
                    if (! Str::startsWith($mime, 'image/')) {
                        $fail("The $attribute must be an image.");
                    }
                }
            ],
            'status' => Rule::in(EventStatus::cases()),
            'tags' => 'array',
            'tags.*' => 'string',
            'start_at' => 'date',
            'end_at' => 'date',
            'address' => 'array',
            'address.url' => 'url',
            'address.street' => 'string',
            'address.city' => 'string',
            'address.province' => 'string',
            'address.country' => 'string',
            'address.note' => 'string',
            'streaming_urls' => 'array',
            'streaming_urls.*' => 'url',
            'guests' => 'array',
            'guests.*' => 'string',
            'hosts' => 'array',
            'hosts.*' => 'string',
            'participate_start_at' => 'date',
            'participate_end_at' => 'date',
            'participate_conditions' => 'array',
            'participate_conditions.*.type' => Rule::in(EventParticipationConditionType::cases()),
            'participate_conditions.*.operator' => Rule::in(['==', '>', '<', '>=', '<=']),
            'participate_conditions.*.value' => 'nullable',
            'min_participant' => 'integer|min:0',
            'max_participant' => 'integer|min:0',
            'bundles' => 'array',
            'bundles.*.name' => 'string',
            'bundles.*.description' => 'string',
            'bundles.*.price' => 'numeric',
            'bundles.*.cancelable' => 'boolean',
            'contacts' => 'array',
            'contacts.*.username' => 'nullable|string',
            'contacts.*.phone_number' => 'nullable|string',
            'contacts.*.email' => 'nullable|email',
            'partners' => 'nullable|array',
            'partners.*.username' => 'nullable|string',
            'partners.*.url' => 'nullable|url',
            'partners.*.image_url' => 'nullable|url',
            'partners.*.phone_number' => 'nullable|string',
            'partners.*.email' => 'nullable|email',
            'sponsors' => 'nullable|array',
            'sponsors.*.username' => 'nullable|string',
            'sponsors.*.url' => 'nullable|url',
            'sponsors.*.image_url' => 'nullable|url',
            'sponsors.*.phone_number' => 'nullable|string',
            'sponsors.*.email' => 'nullable|email',
        ];
    }
}
