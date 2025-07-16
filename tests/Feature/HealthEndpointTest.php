<?php

namespace Tests\Feature;

use Tests\TestCase;

class HealthEndpointTest extends TestCase
{
    public function test_health_endpoint_returns_ok()
    {
        $response = $this->get('/health');
        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'ok',
                 ]);
    }
}
