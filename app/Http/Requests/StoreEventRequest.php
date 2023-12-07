<?php

namespace App\Http\Requests;

use App\Enums\EventParticipationConditionType;
use App\Enums\EventStatus;
use App\Enums\RoleAbility;
use App\Models\Temple;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StoreEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->currentAccessToken()->canAny(RoleAbility::EVENT_CREATE->value, RoleAbility::EVENT_CREATE->value.':'.$this->temple_id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:5|max:250',
            'description' => 'string',
            'cover_image_url'   => 'required_without:cover_image|url',
            'cover_image'       => [
                'required_without:cover_image_url',
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
            'start_at' => 'required|date',
            'end_at' => 'date',
            'temple_id' => [
                $this->user()->currentAccessToken()->cant(RoleAbility::EVENT_CREATE->value) ? 'required' : '',
                Rule::exists(Temple::class, '_id')
            ],
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
            'partners.*.name' => 'nullable|string',
            'partners.*.url' => 'nullable|url',
            'partners.*.image_url' => 'nullable|url',
            'sponsors' => 'nullable|array',
            'sponsors.*.name' => 'nullable|string',
            'sponsors.*.url' => 'nullable|url',
            'sponsors.*.image_url' => 'nullable|url'
        ];
    }
}
