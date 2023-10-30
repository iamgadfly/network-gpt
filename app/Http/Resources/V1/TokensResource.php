<?php

namespace App\Http\Resources\V1;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TokensResource extends JsonResource
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
            'id'         => $this->id,
            'token'      => $this->token,
            'expires_at' => Carbon::parse($this->expires_at)->format(
                'Y-m-d'
            ),
        ];
    }

}
