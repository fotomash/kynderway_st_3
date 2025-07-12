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

        $user = $request->user();
        $user->fcm_token = $request->token;
        $user->save();

        return response()->json(['success' => true]);
    }

    public function unregister(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $user = $request->user();
        if ($user->fcm_token === $request->token) {
            $user->fcm_token = null;
            $user->save();
        }

        return response()->json(['success' => true]);
    }
}
