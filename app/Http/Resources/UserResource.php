<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class UserResource extends JsonResource
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
            'username' => $this->username,
            'roles' => $this->roles,
            'status' => $this->status,
            'email' => Str::mask($this->email, '*', 2, -2),
            'email_verified_at' => $this->email_verified_at,
            'phone_number' => Str::mask($this->phone_number, '*', 2, -2),
            'phone_number_verified_at' => $this->phone_number_verified_at,
            'gender' => $this->gender,
            'zodiac' => $this->zodiac,
            'shio' => $this->shio,
            'element' => $this->element,
            'birth_at' => $this->birth_at,
            'address' => $this->address,
            'temples' => $this->temples,
            'count_temples' => $this->count_temples,
            'events' => $this->events,
            'count_events' => $this->count_events,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
