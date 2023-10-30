<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class YoukassaResource extends JsonResource
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
            'sum'    => $this->sum,
            'status' => $this->status,
            'link'   => $this->payment_link,
        ];
    }

}
