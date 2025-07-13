<?php

namespace App\Services;

use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class TwoFactorService
{
    protected Google2FA $google2fa;

    public function __construct(Google2FA $google2fa)
    {
        $this->google2fa = $google2fa;
    }

    /**
     * Generate a new Google2FA secret key.
     */
    public function generateSecretKey(): string
    {
        return $this->google2fa->generateSecretKey();
    }

    /**
     * Generate a base64 encoded QR code image for setup.
     */
    public function generateQrCode(string $company, string $email, string $secret, int $size = 200): string
    {
        $url = $this->google2fa->getQRCodeUrl($company, $email, $secret);

        $writer = new Writer(
            new ImageRenderer(
                new RendererStyle($size),
                new SvgImageBackEnd()
            )
        );

        return 'data:image/svg+xml;base64,' . base64_encode($writer->writeString($url));
    }

    /**
     * Verify a provided one time password.
     */
    public function verifyOtp(string $secret, string $otp): bool
    {
        return $this->google2fa->verifyKey($secret, $otp);
    }
}
