<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobResource;
use App\Models\Job_Posts;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        return JobResource::collection(Job_Posts::all());
    }

    public function show(Job_Posts $job)
    {
        return new JobResource($job);
    }
}
