<?php

namespace Tests\Feature;

use App\Models\Job_Posts;
use App\Models\Profile_Posts;
use App\Models\User;
use App\Services\MatchingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SocialEngineeringPoCTest extends TestCase
{
    use RefreshDatabase;

    public function test_malicious_job_post_matches_providers()
    {
        // Create a fake parent user (malicious actor)
        $parent = User::factory()->create([
            'type' => 'service_seeker',
        ]);

        // Create a job post with suspicious content
        $job = Job_Posts::create([
            'user_id' => $parent->id,
            'profile_category_id' => 1,
            'jobtypes' => 'full_time',
            'jobtitle' => 'Nanny Needed',
            'postalcode' => '12345',
            'country' => 'US',
            'city' => 'Testville',
            'landmark' => 'Center',
            'address' => '123 Test St',
            'latitude' => 40.0,
            'longitude' => -75.0,
            'jobduration' => '6 months',
            'position' => 'nanny',
            'workwith' => 'kids',
            'req_language' => 'en',
            'pref_language' => 'en',
            'asap' => 'yes',
            'start_date' => '2024-01-01',
            'payamountcurrency' => 'USD',
            'payamount_from' => 15,
            'payamount_to' => 25,
            'payfrequency' => 'hour',
            'hoursperweek' => '40',
            'schedule_mon' => 'all',
            'schedule_tue' => 'all',
            'schedule_wed' => 'all',
            'schedule_thur' => 'all',
            'schedule_fri' => 'all',
            'schedule_sat' => 'none',
            'schedule_sun' => 'none',
            'job_details' => 'Visit http://malicious.example.com for details.',
            'publish' => 1,
        ]);

        // Create two service providers with profiles
        $provider1 = User::factory()->create(['type' => 'service_provider', 'is_block' => 0]);
        $provider2 = User::factory()->create(['type' => 'service_provider', 'is_block' => 0]);

        Profile_Posts::create([
            'provider_id' => $provider1->id,
            'profile_category_id' => 1,
            'job_duration' => 'any',
            'currency' => 'USD',
            'payamount' => 20,
            'payfrequency' => 'hour',
            'jobtypes' => 'full_time',
            'experience1' => '1',
            'experience2' => '2',
            'workwith' => 'kids',
            'worksector' => 'home',
            'carvalue' => true,
            'licensevalue' => true,
            'qualificationsvalue' => true,
            'recordvalue' => false,
            'aidvalue' => false,
            'refvalue' => false,
            'edu_description' => 'test',
            'latitude' => 40.1,
            'longitude' => -75.1,
        ]);

        Profile_Posts::create([
            'provider_id' => $provider2->id,
            'profile_category_id' => 1,
            'job_duration' => 'any',
            'currency' => 'USD',
            'payamount' => 22,
            'payfrequency' => 'hour',
            'jobtypes' => 'full_time',
            'experience1' => '1',
            'experience2' => '2',
            'workwith' => 'kids',
            'worksector' => 'home',
            'carvalue' => true,
            'licensevalue' => true,
            'qualificationsvalue' => true,
            'recordvalue' => false,
            'aidvalue' => false,
            'refvalue' => false,
            'edu_description' => 'test',
            'latitude' => 41.0,
            'longitude' => -76.0,
        ]);

        $service = new MatchingService();
        $matches = $service->findMatchingNannies($job, 50);

        $this->assertCount(2, $matches);
        $this->assertStringContainsString('malicious.example.com', $job->job_details);
    }
}
