<?php

namespace Tests\Unit;

use App\Services\GoogleMapsService;
use GoogleMaps\Facade\GoogleMapsFacade as GoogleMaps;
use Mockery;
use Tests\TestCase;

class GoogleMapsServiceTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_geocode_address_parses_response()
    {
        $json = json_encode([
            'status' => 'OK',
            'results' => [[
                'formatted_address' => '1600 Amphitheatre Parkway, Mountain View, CA 94043, USA',
                'geometry' => [
                    'location' => ['lat' => 37.422, 'lng' => -122.084],
                ],
                'address_components' => [
                    ['long_name' => 'Mountain View', 'types' => ['locality']],
                    ['long_name' => '94043', 'types' => ['postal_code']],
                ],
            ]],
        ]);

        Mockery::mock('alias:' . GoogleMaps::class)
            ->shouldReceive('load')->with('geocoding')->andReturnSelf()
            ->shouldReceive('setParam')->with(['address' => 'test'])->andReturnSelf()
            ->shouldReceive('get')->andReturn($json);

        $service = new GoogleMapsService();
        $result = $service->geocodeAddress('test');

        $this->assertEquals([
            'lat' => 37.422,
            'lng' => -122.084,
            'formatted_address' => '1600 Amphitheatre Parkway, Mountain View, CA 94043, USA',
            'city' => 'Mountain View',
            'postcode' => '94043',
        ], $result);
    }

    public function test_get_nearby_places_parses_response()
    {
        $json = json_encode([
            'status' => 'OK',
            'results' => [[
                'name' => 'Place 1',
                'geometry' => ['location' => ['lat' => 1, 'lng' => 2]],
                'vicinity' => 'Vicinity 1',
                'place_id' => 'id1',
            ], [
                'name' => 'Place 2',
                'geometry' => ['location' => ['lat' => 3, 'lng' => 4]],
                'vicinity' => 'Vicinity 2',
                'place_id' => 'id2',
            ]],
        ]);

        Mockery::mock('alias:' . GoogleMaps::class)
            ->shouldReceive('load')->with('nearbysearch')->andReturnSelf()
            ->shouldReceive('setParam')->andReturnSelf()
            ->shouldReceive('get')->andReturn($json);

        $service = new GoogleMapsService();
        $result = $service->getNearbyPlaces(0, 0);

        $this->assertCount(2, $result);
        $this->assertEquals('Place 1', $result[0]['name']);
        $this->assertEquals(['lat' => 1, 'lng' => 2], $result[0]['location']);
    }

    public function test_calculate_distance_parses_response()
    {
        $json = json_encode([
            'status' => 'OK',
            'rows' => [[
                'elements' => [[
                    'distance' => ['text' => '1 km', 'value' => 1000],
                    'duration' => ['text' => '5 mins', 'value' => 300],
                ]],
            ]],
        ]);

        Mockery::mock('alias:' . GoogleMaps::class)
            ->shouldReceive('load')->with('distancematrix')->andReturnSelf()
            ->shouldReceive('setParam')->andReturnSelf()
            ->shouldReceive('get')->andReturn($json);

        $service = new GoogleMapsService();
        $result = $service->calculateDistance('a', 'b');

        $this->assertEquals([
            'distance_text' => '1 km',
            'distance_value' => 1000,
            'duration_text' => '5 mins',
            'duration_value' => 300,
        ], $result);
    }
}

