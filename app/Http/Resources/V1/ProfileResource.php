<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param   \Illuminate\Http\Request  $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($user)
    {
        return parent::toArray($user);
    }

}
