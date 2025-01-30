<?php

namespace App\Http\Resources;

use App\Models\PWASetting;
use Illuminate\Http\Resources\Json\JsonResource;

class PWAResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            "splash"    => $this->splash,
            "icon"      => $this->icon,
        ];
    }

}
