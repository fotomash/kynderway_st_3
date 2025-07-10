<?php

namespace App\Services;

use App\Models\Job_Posts;
use App\Interfaces\JobPostInterface;

class JobPostService
{
    private $jobPostRepository;

    public function __construct(JobPostInterface $jobPostRepository)
    {
        $this->jobPostRepository = $jobPostRepository;
    }

    public function deleteReportsAndReportsUser($user)
    {
        $jobs = $this->jobPostRepository->getAll($user->id);
        foreach ($jobs as $job) {
            $reports = $job->reports;
            foreach ($reports as $report) {
                $report->reportUsers()->delete();
            }
            $job->reports()->delete();
        }
    }

    public function delete($id)
    {
        return $this->jobPostRepository->delete($id);
    }
}
