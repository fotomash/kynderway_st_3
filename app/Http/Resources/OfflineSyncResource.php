<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;
use App\Models\User;

class OfflineSyncResource extends JsonResource
{
    public static $wrap = null;
    public function toArray($request)
    {
        $records = Cache::get("offline-records:{$this->id}", []);

        if (isset($records['nannies']) && is_array($records['nannies'])) {
            $records['nannies'] = User::query()
                ->whereIn('id', $records['nannies'])
                ->nearby([
                    'lat' => $this->resource->latitude,
                    'lng' => $this->resource->longitude,
                ], 20)
                ->get()
                ->map(fn ($user) => new UserResource($user))
                ->all();
        }

        return [
            'profile' => new UserResource($this->resource),
            'cached_records' => $records,
        ];
    }
}
