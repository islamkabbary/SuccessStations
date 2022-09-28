<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'city' => $this->city ? $this->city->name : null,
            'city_id' => $this->city_id,
            'location_type' => $this->location_type,
            'building_type' => $this->building_type,
            'street_name' => $this->street_name,
            'building_number' => $this->building_number,
            'turn_number' => $this->turn_number,
            'apartment_number' => $this->apartment_number,
            'location_details' => $this->location_details,
            'is_default' => $this->is_default,
        ];
    }
}
