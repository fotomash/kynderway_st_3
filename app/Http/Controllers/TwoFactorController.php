<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TwoFactorService;

class TwoFactorController extends Controller
{
    private TwoFactorService $twoFactorService;

    public function __construct(TwoFactorService $twoFactorService)
    {
        $this->twoFactorService = $twoFactorService;
    }

    /**
     * Generate a secret and QR code for 2FA setup.
     */
    public function enable(Request $request)
    {
        $secret = $this->twoFactorService->generateSecretKey();
        $qr = $this->twoFactorService->generateQrCode(config('app.name'), $request->user()->email, $secret);

        return response()->json([
            'secret' => $secret,
            'qr' => $qr,
        ]);
    }

    /**
     * Verify a 2FA OTP code.
     */
    public function verify(Request $request)
    {
        $validated = $request->validate([
            'secret' => 'required',
            'code' => 'required',
        ]);

        $valid = $this->twoFactorService->verifyOtp($validated['secret'], $validated['code']);

        return response()->json(['valid' => $valid]);
    }
}
