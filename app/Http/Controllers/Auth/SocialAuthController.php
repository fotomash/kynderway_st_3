<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SocialAccount;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class SocialAuthController extends Controller
{
    /**
     * Redirect to provider
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle provider callback
     */
    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            $user = User::updateOrCreate(
                [
                    'email' => $socialUser->getEmail(),
                ],
                [
                    'name' => $socialUser->getName(),
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'avatar' => $socialUser->getAvatar(),
                ]
            );

            $user->socialAccounts()->updateOrCreate(
                [
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                ],
                [
                    'token' => $socialUser->token,
                    'refresh_token' => $socialUser->refreshToken,
                    'expires_at' => $socialUser->expiresIn ? now()->addSeconds($socialUser->expiresIn) : null,
                ]
            );

            Auth::login($user);

            return redirect()->intended('/dashboard');
        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Authentication failed');
        }
    }
}
