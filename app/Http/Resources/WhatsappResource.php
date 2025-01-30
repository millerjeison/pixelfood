<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class WhatsappResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'              => $this->id ?? 0,
            "branch"          => $this->branch ?? "",
            "phone"           => $this->phone ?? "",
            "status"          => $this->status ?? "",
        ];
    }
}