<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

class OfflineSyncResource extends JsonResource
{
    public static $wrap = null;
    public function toArray($request)
    {
        return [
            'profile' => new UserResource($this->resource),
            'cached_records' => Cache::get("offline-records:{$this->id}", []),
        ];
    }
}
