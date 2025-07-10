<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\UserVerificationEmail;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class OtpVerificationTest extends TestCase
{
    use RefreshDatabase;

    private function bypassRecaptcha(): void
    {
        Validator::extend('recaptcha', function () {
            return true;
        });
    }

    public function test_otp_email_is_queued_when_registering(): void
    {
        Notification::fake();
        $this->bypassRecaptcha();

        $response = $this->post('/register', [
            'firstname' => 'Test',
            'lastname' => 'User',
            'email' => 'test@example.com',
            'password' => 'Password1!',
            'terms_condition' => '1',
            'g-recaptcha-response' => 'token',
        ]);

        $user = User::where('email', 'test@example.com')->first();

        Notification::assertSentTo($user, UserVerificationEmail::class);
        $this->assertAuthenticatedAs($user);
        $response->assertStatus(200);
    }

    public function test_otp_verification_succeeds_with_correct_code(): void
    {
        Event::fake();

        $user = User::factory()->create([
            'email_verified_at' => null,
            'otp' => '1234',
            'otp_send_at' => now(),
        ]);

        $response = $this->actingAs($user)->post('/verify-otp', ['otp' => '1234']);

        Event::assertDispatched(Verified::class);
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
        $response->assertRedirect(RouteServiceProvider::INDIVIDUAL_MANAGE_PROFILE.'?verified=1');
    }

    public function test_otp_verification_fails_with_incorrect_code(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
            'otp' => '1234',
            'otp_send_at' => now(),
        ]);

        $response = $this->actingAs($user)->post('/verify-otp', ['otp' => '1111']);

        $this->assertFalse($user->fresh()->hasVerifiedEmail());
        $response->assertSessionHas('alert-danger');
    }

    public function test_resend_route_generates_new_otp(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email_verified_at' => null,
            'otp' => '1234',
            'otp_send_at' => now(),
        ]);

        $oldOtp = $user->otp;

        $this->actingAs($user)->post('/verify-resend-otp');

        $user->refresh();

        $this->assertNotEquals($oldOtp, $user->otp);
        Notification::assertSentTo($user, UserVerificationEmail::class);
    }
}
