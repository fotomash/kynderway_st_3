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

        if ($result && $result->status === 'OK') {
            $components = $result->results[0]->address_components;
            $city = null;
            $postcode = null;

            foreach ($components as $component) {
                if (in_array('locality', $component->types, true)) {
                    $city = $component->long_name;
                }

                if (in_array('postal_code', $component->types, true)) {
                    $postcode = $component->long_name;
                }
            }

            return [
                'lat' => $result->results[0]->geometry->location->lat,
                'lng' => $result->results[0]->geometry->location->lng,
                'formatted_address' => $result->results[0]->formatted_address,
                'city' => $city,
                'postcode' => $postcode,
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

        $result = json_decode($response);

        if ($result && $result->status === 'OK') {
            $places = [];

            foreach ($result->results as $place) {
                $places[] = [
                    'name' => $place->name,
                    'location' => [
                        'lat' => $place->geometry->location->lat,
                        'lng' => $place->geometry->location->lng,
                    ],
                    'vicinity' => $place->vicinity ?? null,
                    'place_id' => $place->place_id ?? null,
                ];
            }

            return $places;
        }

        return null;
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

        $result = json_decode($response);

        if ($result && $result->status === 'OK') {
            $element = $result->rows[0]->elements[0] ?? null;

            if ($element && isset($element->distance, $element->duration)) {
                return [
                    'distance_text' => $element->distance->text,
                    'distance_value' => $element->distance->value,
                    'duration_text' => $element->duration->text,
                    'duration_value' => $element->duration->value,
                ];
            }
        }

        return null;
    }
}
