<?php

namespace Tests\Feature;

use App\Events\PaymentSuccessful;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class StripeWebhookTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->string('stripe_connect_id')->nullable();
            $table->boolean('stripe_onboarding_complete')->default(false);
            $table->json('stripe_account_capabilities')->nullable();
            $table->timestamps();
        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('nanny_id');
            $table->string('payment_status')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->string('stripe_payment_intent_id');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('users');

        parent::tearDown();
    }

    public function test_marks_payment_as_succeeded()
    {
        $secret = 'whsec_test';
        config(['services.stripe.webhook_secret' => $secret]);

        $parent = User::factory()->create();
        $nanny = User::factory()->create();

        $booking = Booking::create([
            'parent_id' => $parent->id,
            'nanny_id' => $nanny->id,
        ]);

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'stripe_payment_intent_id' => 'pi_test',
            'status' => 'pending',
        ]);

        $payload = json_encode([
            'type' => 'payment_intent.succeeded',
            'data' => [
                'object' => ['id' => 'pi_test'],
            ],
        ]);

        $timestamp = time();
        $signature = hash_hmac('sha256', $timestamp . '.' . $payload, $secret);
        $header = 't=' . $timestamp . ',v1=' . $signature;

        Event::fake();

        $response = $this->withHeaders([
            'Stripe-Signature' => $header,
        ])->postJson('/api/stripe/webhook', json_decode($payload, true));

        $response->assertStatus(200);
        $this->assertSame('succeeded', $payment->fresh()->status);
        Event::assertDispatched(PaymentSuccessful::class);
    }
}
