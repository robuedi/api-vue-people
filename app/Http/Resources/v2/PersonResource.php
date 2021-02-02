<?php

namespace App\Http\Resources\v2;

use App\Http\Resources\PersonResourceContract;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource implements PersonResourceContract
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'full_name' => $this->first_name.' '.$this->last_name,
            'phone'     => $this->phone
        ];
    }
}
