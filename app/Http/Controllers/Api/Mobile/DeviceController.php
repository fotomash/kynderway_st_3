<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        // Store or update device token here
        return response()->json(['success' => true]);
    }

    public function unregister(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        // Remove device token here
        return response()->json(['success' => true]);
    }
}
