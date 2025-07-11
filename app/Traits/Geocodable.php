<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait Geocodable
{
    protected static function bootGeocodable()
    {
        static::saving(function ($model) {
            if ($model->isDirty('address')) {
                $model->fillCoordinates();
            }
        });
    }

    public function fillCoordinates()
    {
        if (!empty($this->address)) {
            try {
                $response = Http::get('https://nominatim.openstreetmap.org/search', [
                    'q' => $this->address,
                    'format' => 'json',
                    'limit' => 1,
                ]);
                if ($response->successful() && isset($response[0]['lat'])) {
                    $this->latitude = $response[0]['lat'];
                    $this->longitude = $response[0]['lon'];
                }
            } catch (\Exception $e) {
                // ignore failures
            }
        }
    }
}
