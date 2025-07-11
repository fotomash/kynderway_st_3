<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiEndpointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_jobs_endpoint_returns_success()
    {
        $response = $this->get('/api/v1/jobs');
        $response->assertStatus(200)->assertJson(['data' => []]);
    }

    public function test_profiles_endpoint_returns_success()
    {
        $response = $this->get('/api/v1/profiles');
        $response->assertStatus(200)->assertJson(['data' => []]);
    }

    public function test_profiles_nearby_endpoint_returns_success()
    {
        \DB::table('users')->insert([
            'id' => 1,
            'address' => 'London',
            'latitude' => 51.5,
            'longitude' => -0.12,
        ]);

        \DB::table('profile_posts')->insert([
            'provider_id' => 1,
            'profile_category_id' => 1,
            'payamount' => 100,
            'currency' => 'USD',
        ]);

        $response = $this->get('/api/v1/profiles/nearby?lat=51.5&lng=-0.12&radius=10');
        $response->assertStatus(200)->assertJsonStructure(['data']);
    }
}
