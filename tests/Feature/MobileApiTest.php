<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Tests\TestCase;

class MobileApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_mobile_user_can_login_access_routes_and_logout(): void
    {
        $user = User::factory()->create(['password' => bcrypt('secret')]);

        $login = $this->postJson('/api/mobile/v1/login', [
            'email' => $user->email,
            'password' => 'secret',
            'device_name' => 'testing',
        ]);

        $login->assertOk()->assertJsonStructure(['token', 'user']);
        $token = $login->json('token');

        $home = $this->withToken($token)->getJson('/api/mobile/v1/home');
        $home->assertOk()->assertJson(['message' => 'Welcome to the mobile API']);

        $this->withToken($token)->postJson('/api/mobile/v1/logout')->assertOk();
    }

    public function test_login_fails_with_invalid_credentials(): void
    {
        $user = User::factory()->create(['password' => bcrypt('secret')]);

        $response = $this->postJson('/api/mobile/v1/login', [
            'email' => $user->email,
            'password' => 'wrong',
            'device_name' => 'testing',
        ]);

        $response->assertStatus(422);
    }

    public function test_mobile_endpoints_require_authentication(): void
    {
        $this->getJson('/api/mobile/v1/home')->assertUnauthorized();
        $this->postJson('/api/mobile/v1/device/register', ['token' => 't'])->assertUnauthorized();
    }

    public function test_mobile_api_rate_limiter_uses_user_or_ip(): void
    {
        $user = User::factory()->make(['id' => 9]);
        $request = Request::create('/api/mobile/v1/home', 'GET', [], [], [], ['REMOTE_ADDR' => '1.1.1.1']);
        $request->setUserResolver(fn () => $user);

        $limiter = RateLimiter::limiter('mobile-api');
        $limit = $limiter($request);

        $this->assertEquals(100, $limit->maxAttempts);
        $this->assertEquals(1, $limit->decayMinutes);
        $this->assertEquals($user->id, $limit->key);

        $guest = Request::create('/api/mobile/v1/home', 'GET', [], [], [], ['REMOTE_ADDR' => '2.2.2.2']);
        $guest->setUserResolver(fn () => null);

        $limitGuest = $limiter($guest);
        $this->assertEquals('2.2.2.2', $limitGuest->key);
    }

    public function test_offline_sync_endpoint_returns_cached_records(): void
    {
        $user = User::factory()->create(['password' => bcrypt('secret')]);

        $login = $this->postJson('/api/mobile/v1/login', [
            'email' => $user->email,
            'password' => 'secret',
            'device_name' => 'testing',
        ]);
        $token = $login->json('token');

        \Cache::put("offline-records:{$user->id}", ['foo'], 60);

        $this->withToken($token)->getJson('/api/mobile/v1/offline-data')
            ->assertOk()
            ->assertJson([
                'cached_records' => ['foo'],
            ])
            ->assertJsonStructure(['profile', 'cached_records']);
    }
}
