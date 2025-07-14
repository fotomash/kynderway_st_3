# SOCIAL LOGIN IMPLEMENTATION FOR KINDERWAY

## 1. Social Authentication Controller

```php
// app/Http/Controllers/Auth/SocialAuthController.php
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AuthService;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SocialAuthController extends Controller
{
    private $authService;
    
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    
    /**
     * Redirect to provider
     */
    public function redirect($provider)
    {
        $this->validateProvider($provider);
        
        // For mobile apps, return the URL instead of redirecting
        if (request()->wantsJson()) {
            return response()->json([
                'url' => Socialite::driver($provider)->stateless()->redirect()->getTargetUrl()
            ]);
        }
        
        return Socialite::driver($provider)->redirect();
    }
    
    /**
     * Handle provider callback
     */
    public function callback($provider, Request $request)
    {
        $this->validateProvider($provider);
        
        try {
            // Handle mobile app callbacks differently
            if ($request->has('code') && $request->wantsJson()) {
                $socialUser = Socialite::driver($provider)->stateless()->user();
            } else {
                $socialUser = Socialite::driver($provider)->user();
            }
            
            $user = $this->findOrCreateUser($socialUser, $provider);
            
            // For API/mobile, return token
            if ($request->wantsJson()) {
                $token = $user->createToken('social-login')->plainTextToken;
                
                return response()->json([
                    'user' => $user,
                    'token' => $token,
                    'token_type' => 'Bearer'
                ]);
            }
            
            // For web, login and redirect
            Auth::login($user, true);
            
            // Check if user needs to complete profile
            if (!$user->profile_completed) {
                return redirect()->route('profile.complete');
            }
            
            return redirect()->intended('/dashboard');
            
        } catch (\Exception $e) {
            \Log::error('Social login failed: ' . $e->getMessage());
            
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Authentication failed'], 401);
            }
            
            return redirect('/login')->with('error', 'Unable to login with ' . ucfirst($provider));
        }
    }
    
    /**
     * Find or create user from social provider
     */
    private function findOrCreateUser($socialUser, $provider)
    {
        return DB::transaction(function () use ($socialUser, $provider) {
            // First, check if user exists with this provider ID
            $socialAccount = DB::table('social_accounts')
                ->where('provider', $provider)
                ->where('provider_id', $socialUser->getId())
                ->first();
            
            if ($socialAccount) {
                return User::find($socialAccount->user_id);
            }
            
            // Check if user exists with same email
            $user = User::where('email', $socialUser->getEmail())->first();
            
            if (!$user) {
                // Create new user
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'email_verified_at' => now(),
                    'password' => bcrypt(Str::random(16)),
                    'profile_photo' => $socialUser->getAvatar(),
                    'registration_source' => 'social_' . $provider
                ]);
                
                // Send welcome email
                event(new \App\Events\UserRegisteredViaSocial($user, $provider));
            }
            
            // Create social account link
            DB::table('social_accounts')->insert([
                'user_id' => $user->id,
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'token' => $socialUser->token,
                'refresh_token' => $socialUser->refreshToken ?? null,
                'expires_at' => $socialUser->expiresIn ? now()->addSeconds($socialUser->expiresIn) : null,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            return $user;
        });
    }
    
    /**
     * Validate provider
     */
    private function validateProvider($provider)
    {
        if (!in_array($provider, ['google', 'apple', 'facebook'])) {
            abort(404);
        }
    }
}
```

