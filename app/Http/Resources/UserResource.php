<?php

namespace App\Http\Resources;

use App\Models\Specialization;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $specialization_uuid=Specialization::find($this->specialization_id);
        return [
            'token'=>$this->token,
            'user_uuid'=>$this->uuid,
            'specialization_uuid'=>$specialization_uuid->uuid,
            'username'=>$this->username,
            'phone'=>$this->phone,
            'role'=>$this->role ? 'admin' : 'normal',
            'photo'=>$this->photo,
//            'code'=>$this->code,
        ];
    }
}
