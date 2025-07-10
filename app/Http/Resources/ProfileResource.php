<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'category' => $this->profile_category_id,
            'payamount' => $this->payamount,
            'currency' => $this->currency,
            'created_at' => $this->created_at,
        ];
    }
}
