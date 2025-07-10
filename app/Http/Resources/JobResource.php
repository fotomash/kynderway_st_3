<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->jobtitle,
            'city' => $this->city,
            'country' => $this->country,
            'created_at' => $this->created_at,
        ];
    }
}
