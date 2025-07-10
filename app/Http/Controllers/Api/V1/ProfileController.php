<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\Profile_Posts;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * List all profiles
     *
     * Returns a collection of work profiles.
     *
     * @group Profiles
     */
    public function index()
    {
        return ProfileResource::collection(Profile_Posts::all());
    }

    /**
     * Show a specific profile
     *
     * @group Profiles
     *
     * @urlParam profile int required The ID of the profile.
     */
    public function show(Profile_Posts $profile)
    {
        return new ProfileResource($profile);
    }
}
