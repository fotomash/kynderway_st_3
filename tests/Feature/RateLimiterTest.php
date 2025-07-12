<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class RateLimiterTest extends TestCase
{
    public function test_api_premium_rate_limiter_uses_user_id()
    {
        $user = User::factory()->make(['id' => 42]);
        $request = Request::create('/api-premium');
        $request->setUserResolver(fn () => $user);

        $limiter = RateLimiter::limiter('api-premium');
        $limit = $limiter($request);

        $this->assertEquals(200, $limit->maxAttempts);
        $this->assertEquals(1, $limit->decayMinutes);
        $this->assertEquals($user->id, $limit->key);
    }

    public function test_search_rate_limiter_uses_user_or_ip()
    {
        $user = User::factory()->make(['id' => 77]);
        $request = Request::create('/search', 'GET', [], [], [], ['REMOTE_ADDR' => '10.0.0.1']);
        $request->setUserResolver(fn () => $user);

        $limiter = RateLimiter::limiter('search');
        $limit = $limiter($request);

        $this->assertEquals(30, $limit->maxAttempts);
        $this->assertEquals(1, $limit->decayMinutes);
        $this->assertEquals($user->id, $limit->key);

        $requestGuest = Request::create('/search', 'GET', [], [], [], ['REMOTE_ADDR' => '10.0.0.2']);
        $requestGuest->setUserResolver(fn () => null);

        $limitGuest = $limiter($requestGuest);
        $this->assertEquals('10.0.0.2', $limitGuest->key);
    }

    public function test_credit_purchase_rate_limiter_per_hour()
    {
        $user = User::factory()->make(['id' => 5]);
        $request = Request::create('/credit', 'POST');
        $request->setUserResolver(fn () => $user);

        $limiter = RateLimiter::limiter('credit-purchase');
        $limit = $limiter($request);

        $this->assertEquals(10, $limit->maxAttempts);
        $this->assertEquals(60, $limit->decayMinutes);
        $this->assertEquals($user->id, $limit->key);
    }
}
