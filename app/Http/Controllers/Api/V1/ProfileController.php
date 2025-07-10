<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\Profile_Posts;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return ProfileResource::collection(Profile_Posts::all());
    }

    public function show(Profile_Posts $profile)
    {
        return new ProfileResource($profile);
    }
}
