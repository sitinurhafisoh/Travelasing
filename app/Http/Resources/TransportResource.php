<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_transport,
            'code' => $this->code,
            'description' => $this->description,
            'seat' => $this->seat,
            'transport_type' => $this->whenLoaded('transportType', function () {
                return new TransportTypeResource($this->transportType);
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
