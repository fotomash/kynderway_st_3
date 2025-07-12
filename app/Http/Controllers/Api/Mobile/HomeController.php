<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'message' => 'Welcome to the mobile API',
            'user' => $request->user(),
        ]);
    }
}
