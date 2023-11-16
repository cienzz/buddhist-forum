<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TempleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            '_id' => $this->_id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'phone_numbers' => $this->phone_numbers,
            'emails' => $this->emails,
            'website_url' => $this->website_url,
            'tags' => $this->tags,
            'open_times' => $this->open_times,
            'is_open' => $this->resource->isOpen(),
            'addresses' => $this->addresses,
            'events' => $this->events,
            'banks' => $this->banks,
            'count_members' => $this->count_members,
            'members' => $this->members,
            'count_social_medias' => $this->count_social_medias,
            'social_medias' => $this->social_medias,
            'count_events' => $this->count_events,
            'events' => $this->events,
            'count_galleries' => $this->count_galleries,
            'galleries' => $this->galleries
        ];
    }
}
