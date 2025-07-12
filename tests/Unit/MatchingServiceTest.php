<?php

namespace Tests\Unit;

use App\Services\MatchingService;
use App\Models\Job_Posts;
use App\Models\Profile_Posts;
use Tests\TestCase;

class MatchingServiceTest extends TestCase
{
    private function stub(): MatchingService
    {
        return new class extends MatchingService {
            public function distance($job, $profile) { return $this->calculateDistanceScore($job, $profile); }
            public function availability($job, $profile) { return $this->calculateAvailabilityScore($job, $profile); }
            public function experience($job, $profile) { return $this->calculateExperienceScore($job, $profile); }
            public function price($job, $profile) { return $this->calculatePriceScore($job, $profile); }
        };
    }

    public function test_distance_score_full_for_same_location()
    {
        $job = new Job_Posts(['latitude' => 1, 'longitude' => 1]);
        $profile = new Profile_Posts(['latitude' => 1, 'longitude' => 1]);

        $service = $this->stub();
        $this->assertEquals(1, $service->distance($job, $profile));
    }

    public function test_availability_score_zero_when_unavailable()
    {
        $job = new Job_Posts(['start_date' => '2024-01-10']);
        $profile = new Profile_Posts(['available_from' => '2024-02-01', 'available_to' => '2024-03-01']);

        $service = $this->stub();
        $this->assertEquals(0, $service->availability($job, $profile));
    }

    public function test_experience_score_caps_at_one()
    {
        $job = new Job_Posts();
        $profile = new Profile_Posts(['experience1' => 2, 'experience2' => 2]);

        $service = $this->stub();
        $this->assertEquals(1, $service->experience($job, $profile));
    }

    public function test_price_score_reduces_when_rate_above_budget()
    {
        $job = new Job_Posts(['payamount_from' => 10, 'payamount_to' => 20]);
        $profile = new Profile_Posts(['payamount' => 25]);

        $service = $this->stub();
        $score = $service->price($job, $profile);
        $this->assertTrue($score < 1 && $score > 0);
    }
}
