<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SpecializationResource extends JsonResource
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
            'specialization_uuid'=>$this->uuid,
            'name'=>$this->name,
            'type'=>$this->type,
            'photo'=>'https://darbnii.000webhostapp.com/'.$this->photo,
        ];
    }
}
