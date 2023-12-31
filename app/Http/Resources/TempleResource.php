<?php

namespace App\Http\Resources;

use App\Enums\RoleAbility;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class TempleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        $data['is_open'] = $this->resource->isOpen();
        if (! Auth::check() || Auth::user()->currentAccessToken()->cant(RoleAbility::TEMPLE_VIEW)) {
            unset($data['members']);
        }
        return $data;
    }
}
