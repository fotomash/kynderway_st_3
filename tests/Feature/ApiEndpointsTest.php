<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ApiEndpointsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('job_posts', function ($table) {
            $table->id();
            $table->string('jobtitle')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('profile_posts', function ($table) {
            $table->id();
            $table->integer('profile_category_id')->nullable();
            $table->decimal('payamount')->nullable();
            $table->string('currency')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('job_posts');
        Schema::dropIfExists('profile_posts');

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
}
