<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param   \Illuminate\Http\Request  $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'     => $this->id,
            'status' => $this->status,
            'text'   => $this->resp,
        ];
    }

}
