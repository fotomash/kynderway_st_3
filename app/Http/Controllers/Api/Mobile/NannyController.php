<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\ProfileController as V1ProfileController;

class NannyController extends Controller
{
    public function nearby(Request $request, V1ProfileController $profiles)
    {
        // Reuse existing profile nearby search
        return $profiles->nearby($request);
    }
}
