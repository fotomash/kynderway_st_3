<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfflineSyncResource;
use Illuminate\Http\Request;

class OfflineSyncController extends Controller
{
    public function index(Request $request)
    {
        return new OfflineSyncResource($request->user());
    }
}
