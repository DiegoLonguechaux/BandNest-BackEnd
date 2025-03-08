<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'structure' => $this->structure,
            'name' => $this->name,
            'size' => $this->size,
            'description' => $this->description,
            'price_per_hour' => $this->price_per_hour,
            'address' => $this->address,
            'city' => $this->city,
            'zip_code' => $this->zip_code,
            'country' => $this->country,
            'photos' => $this->photos,
            'materials' => $this->materials->map(function ($material) {
                return [
                    'name' => $material->name,
                ];
            }),
            'operating_hours' => $this->operatingHours->map(function ($hour) {
                return [
                    'day' => $hour->day,
                    'start' => $hour->start ?: null,
                    'end' => $hour->end ?: null,
                    'closed' => $hour->closed
                ];
            }),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
