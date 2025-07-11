<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ApiEndpointsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('users', function ($table) {
            $table->id();
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });

        Schema::create('job_posts', function ($table) {
            $table->id();
            $table->string('jobtitle')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('profile_posts', function ($table) {
            $table->id();
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->integer('profile_category_id')->nullable();
            $table->decimal('payamount')->nullable();
            $table->string('currency')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('job_posts');
        Schema::dropIfExists('profile_posts');
        Schema::dropIfExists('users');

        parent::tearDown();
    }

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
