<?php

namespace App\Http\Resources;

use App\Http\Resources\ImageResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AdditionalInformationResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'price' => $this->price,
            'company_id' => $this->company_id,
            'company_name' => $this->company->name,
            'status' => $this->status,
            'description' => $this->description,
            'max_qty' => $this->qty,
            'image' => ImageResource::make($this->images),
            'Additional Information' => AdditionalInformationResource::collection($this->informations),
        ];
    }
}
