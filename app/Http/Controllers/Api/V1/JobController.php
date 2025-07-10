<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobResource;
use App\Models\Job_Posts;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * List all jobs
     *
     * Returns a collection of job posts.
     *
     * @group Jobs
     */
    public function index()
    {
        return JobResource::collection(Job_Posts::all());
    }

    /**
     * Show a specific job
     *
     * @group Jobs
     *
     * @urlParam job int required The ID of the job.
     */
    public function show(Job_Posts $job)
    {
        return new JobResource($job);
    }
}
