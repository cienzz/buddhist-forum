<?php

namespace App\Http\Resources;

use App\Enums\RoleAbility;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = parent::toArray($request);
        if (! Auth::check() || Auth::user()->currentAccessToken()->cant(RoleAbility::EVENT_VIEW)) {
            unset($data['participants']);
        }
        return $data;
    }
}
