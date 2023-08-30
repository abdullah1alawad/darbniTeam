<?php

namespace App\Http\Resources;

use App\Models\Specialization;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $specialization=Specialization::find($this->specialization_id);

        return [
            'subject_uuid'=>$this->uuid,
            'specialization_uuid'=>$specialization->uuid,
            'name'=>$this->name,
            'level'=>$this->level,
        ];
    }
}
