<?php

namespace Tests\Feature;

use App\Services\GoogleMapsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VacationCareTest extends TestCase
{
    use RefreshDatabase;

    public function test_vacation_care_search_returns_success()
    {
        $service = $this->createMock(GoogleMapsService::class);
        $service->method('geocodeAddress')->willReturn(['lat' => 0, 'lng' => 0]);
        app()->instance(GoogleMapsService::class, $service);

        $response = $this->postJson('/api/vacation-care/search', [
            'destination' => 'London',
            'start_date' => now()->addDay()->toDateString(),
            'end_date' => now()->addDays(2)->toDateString(),
            'children_ages' => [5],
            'care_schedule' => [],
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'local_nannies',
            'traveling_nannies',
            'destination_insights',
            'estimated_local_rates',
        ]);
    }
}
