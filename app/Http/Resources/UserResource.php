<?php

namespace App\Http\Resources;

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
        return [
            'token'=>$this->token,
            'uuid'=>$this->uuid,
            'specialization_id'=>$this->specialization_id,
            'username'=>$this->username,
            'phone'=>$this->phone,
            'role'=>$this->role ? 'admin' : 'normal',
            'photo'=>$this->photo,
//            'code'=>$this->code,
        ];
    }
}
