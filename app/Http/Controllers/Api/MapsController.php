<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GoogleMapsService;
use Illuminate\Http\Request;

class MapsController extends Controller
{
    protected $mapsService;

    public function __construct(GoogleMapsService $mapsService)
    {
        $this->mapsService = $mapsService;
    }

    /**
     * @OA\Post(
     *     path="/api/maps/geocode",
     *     summary="Geocode an address",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="address", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Success")
     * )
     */
    public function geocode(Request $request)
    {
        $request->validate(['address' => 'required|string']);

        $result = $this->mapsService->geocodeAddress($request->address);

        return response()->json($result);
    }
}
