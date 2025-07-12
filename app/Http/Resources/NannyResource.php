<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NannyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'rating' => round($this->reviewsReceived()->avg('rating') ?? 0, 2),
        ];
    }
}
