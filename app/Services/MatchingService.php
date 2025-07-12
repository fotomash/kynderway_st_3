<?php

namespace App\Services;

use App\Models\Job_Posts;
use App\Models\Profile_Posts;
use Illuminate\Support\Facades\Schema;

class MatchingService
{
    /**
     * Find matching nannies for a job post based on location and pay range.
     * This is a simplified version of the advanced matching algorithm used
     * for demonstration purposes.
     */

    public function __construct(private $mlService = null)
    {
    }

    public function findMatchingNannies(Job_Posts $jobPost, $radius = 10)
    {
        $query = Profile_Posts::query()
            ->with('userdetails')
            ->whereHas('userdetails', function ($q) {
                $q->where('type', 'service_provider')->where('is_block', 0);
            });

        $query = $this->applyLocationFilter($query, $jobPost, $radius);
        $query = $this->applyPayRangeFilter($query, $jobPost);
        $query = $this->applyAvailabilityFilter($query, $jobPost);
        $query = $this->applySkillsFilter($query, $jobPost);

        $profiles = $query->get();

        return $this->calculateMatchScores($jobPost, $profiles);
    }

    protected function applyLocationFilter($query, Job_Posts $jobPost, $radius)
    {
        if ($jobPost->latitude && $jobPost->longitude) {
            $haversine = "(3959 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude))))";

            $query->select('*')
                ->selectRaw("{$haversine} AS distance", [
                    $jobPost->latitude,
                    $jobPost->longitude,
                    $jobPost->latitude,
                ])
                ->having('distance', '<=', $radius);
        }

        return $query;
    }

    protected function applyPayRangeFilter($query, Job_Posts $jobPost)
    {
        return $query->where('payamount', '>=', $jobPost->payamount_from)
            ->where('payamount', '<=', $jobPost->payamount_to);
    }

    protected function applyAvailabilityFilter($query, Job_Posts $jobPost)
    {
        if (Schema::hasColumns('profile_posts', ['available_from', 'available_to'])) {
            $query->where(function ($q) use ($jobPost) {
                $q->whereNull('available_from')
                    ->orWhere('available_from', '<=', $jobPost->start_date);
            })
                ->where(function ($q) use ($jobPost) {
                    $q->whereNull('available_to')
                        ->orWhere('available_to', '>=', $jobPost->start_date);
                });
        }

        return $query;
    }

    protected function applySkillsFilter($query, Job_Posts $jobPost)
    {
        if ($jobPost->workwith) {
            $query->where('workwith', $jobPost->workwith);
        }

        if ($jobPost->req_language) {
            $query->where(function ($q) use ($jobPost) {
                $q->where('experience1', $jobPost->req_language)
                    ->orWhere('experience2', $jobPost->req_language);
            });
        }

        return $query;
    }

    protected function calculateMatchScores(Job_Posts $jobPost, $profiles)
    {
        return $profiles->map(function ($profile) use ($jobPost) {
            $distance = $this->calculateDistanceScore($jobPost, $profile);
            $availability = $this->calculateAvailabilityScore($jobPost, $profile);
            $experience = $this->calculateExperienceScore($jobPost, $profile);
            $price = $this->calculatePriceScore($jobPost, $profile);

            $profile->match_score = ($distance + $availability + $experience + $price) / 4;

            if ($this->mlService && method_exists($this->mlService, 'adjustScore')) {
                $profile->match_score = $this->mlService->adjustScore($jobPost, $profile, $profile->match_score);
            }

            return $profile;
        })->sortByDesc('match_score')->values();
    }

    protected function calculateDistanceScore(Job_Posts $jobPost, Profile_Posts $profile)
    {
        if (!$jobPost->latitude || !$jobPost->longitude || !$profile->latitude || !$profile->longitude) {
            return 0;
        }

        $distance = 3959 * acos(
            cos(deg2rad($jobPost->latitude)) *
            cos(deg2rad($profile->latitude)) *
            cos(deg2rad($profile->longitude) - deg2rad($jobPost->longitude)) +
            sin(deg2rad($jobPost->latitude)) *
            sin(deg2rad($profile->latitude))
        );

        $maxRadius = 50; // miles

        return max(0, 1 - min($distance, $maxRadius) / $maxRadius);
    }

    protected function calculateAvailabilityScore(Job_Posts $jobPost, Profile_Posts $profile)
    {
        if (isset($profile->available_from, $profile->available_to) && $jobPost->start_date) {
            if (($profile->available_from && $jobPost->start_date < $profile->available_from) ||
                ($profile->available_to && $jobPost->start_date > $profile->available_to)) {
                return 0;
            }
        }

        return 1;
    }

    protected function calculateExperienceScore(Job_Posts $jobPost, Profile_Posts $profile)
    {
        $years = (int) ($profile->experience1 ?? 0) + (int) ($profile->experience2 ?? 0);
        $required = 1; // placeholder

        return min(1, $years / max($required, 1));
    }

    protected function calculatePriceScore(Job_Posts $jobPost, Profile_Posts $profile)
    {
        $budget = ($jobPost->payamount_from + $jobPost->payamount_to) / 2;
        $rate = $profile->payamount ?? $budget;

        if ($rate <= $budget) {
            return 1;
        }

        $diff = $rate - $budget;

        return max(0, 1 - $diff / max($budget, 1));
    }
}
