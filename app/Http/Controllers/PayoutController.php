<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PayoutController extends Controller
{
    public function startOnboarding(Request $request)
    {
        // Stubbed onboarding link
        return response()->json(['url' => 'https://example.com/onboard']);
    }

    public function onboardingCallback(Request $request)
    {
        return response()->json(['status' => 'onboarded']);
    }

    public function requestPayout(Request $request)
    {
        return response()->json(['status' => 'payout_requested']);
    }
}
