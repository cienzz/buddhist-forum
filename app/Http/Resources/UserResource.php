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
        $data = parent::toArray($request);

        // $data['phone_number'] = Str::mask($this->phone_number, '*', 2, -2);
        // $data['email'] = Str::mask($this->email, '*', 2, -2);

        return $data;
    }
}
