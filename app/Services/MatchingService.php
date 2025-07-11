<?php

namespace App\Services;

use App\Models\Job_Posts;
use App\Models\Profile_Posts;
use Illuminate\Support\Facades\DB;

class MatchingService
{
    /**
     * Find matching nannies for a job post based on location and pay range.
     * This is a simplified version of the advanced matching algorithm used
     * for demonstration purposes.
     */
    public function findMatchingNannies(Job_Posts $jobPost, $radius = 10)
    {
        $query = Profile_Posts::query()
            ->with('userdetails')
            ->whereHas('userdetails', function ($q) {
                $q->where('type', 'service_provider')->where('is_block', 0);
            });

        // Location based filtering using the Haversine formula
        if ($jobPost->latitude && $jobPost->longitude) {
            $haversine = "(3959 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude))))";
            $query->select('*')
                ->selectRaw("{$haversine} AS distance", [
                    $jobPost->latitude,
                    $jobPost->longitude,
                    $jobPost->latitude
                ])
                ->having('distance', '<=', $radius);
        }

        // Pay range matching
        $query->where('payamount', '>=', $jobPost->payamount_from)
              ->where('payamount', '<=', $jobPost->payamount_to);

        return $query->get();
    }
}
