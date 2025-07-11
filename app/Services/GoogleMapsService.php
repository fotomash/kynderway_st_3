<?php

namespace App\Services;

use GoogleMaps\Facade\GoogleMapsFacade as GoogleMaps;

class GoogleMapsService
{
    /**
     * Get coordinates from address
     */
    public function geocodeAddress($address)
    {
        $response = GoogleMaps::load('geocoding')
            ->setParam(['address' => $address])
            ->get();

        $result = json_decode($response);

        if ($result->status === 'OK') {
            return [
                'lat' => $result->results[0]->geometry->location->lat,
                'lng' => $result->results[0]->geometry->location->lng,
                'formatted_address' => $result->results[0]->formatted_address,
            ];
        }

        return null;
    }

    /**
     * Get nearby places
     */
    public function getNearbyPlaces($lat, $lng, $radius = 1000, $type = 'restaurant')
    {
        $response = GoogleMaps::load('nearbysearch')
            ->setParam([
                'location' => "$lat,$lng",
                'radius' => $radius,
                'type' => $type,
            ])
            ->get();

        return json_decode($response);
    }

    /**
     * Calculate distance between two points
     */
    public function calculateDistance($origin, $destination)
    {
        $response = GoogleMaps::load('distancematrix')
            ->setParam([
                'origins' => $origin,
                'destinations' => $destination,
                'mode' => 'driving',
            ])
            ->get();

        return json_decode($response);
    }
}
