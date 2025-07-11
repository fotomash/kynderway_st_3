<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\Profile_Posts;
use Illuminate\Support\Facades\DB;
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

    /**
     * Nearby providers
     *
     * Returns profiles within the given radius using latitude and longitude.
     *
     * @group Profiles
     *
     * @queryParam lat required Latitude Example: 51.5074
     * @queryParam lng required Longitude Example: -0.1278
     * @queryParam radius required Distance in kilometers Example: 10
     */
    public function nearby(Request $request)
    {
        $data = $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'radius' => 'required|numeric',
        ]);

        $lat = $data['lat'];
        $lng = $data['lng'];
        $radius = $data['radius'];

        $profiles = Profile_Posts::select('profile_posts.*')
            ->join('users', 'users.id', '=', 'profile_posts.provider_id')
            ->selectRaw('(
                6371 * acos(
                    cos(radians(?)) * cos(radians(users.latitude)) * cos(radians(users.longitude) - radians(?)) +
                    sin(radians(?)) * sin(radians(users.latitude))
                )
            ) as distance', [$lat, $lng, $lat])
            ->whereNotNull('users.latitude')
            ->whereNotNull('users.longitude')
            ->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->get();

        return ProfileResource::collection($profiles);
    }
}
