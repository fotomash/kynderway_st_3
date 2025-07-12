<?php

namespace Tests\Integration;

use App\Models\Booking;
use App\Models\User;
use App\Models\UserCredit;
use App\Services\CreditService;
use App\Services\BookingService;
use App\Services\PaymentService;
use App\Services\PushNotificationService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mockery;
use Stripe\PaymentIntent;
use Stripe\Transfer;
use Tests\TestCase;
use Kreait\Firebase\Messaging\MessagingStub;

require_once __DIR__.'/../Stubs/FirebaseStubs.php';

class BookingFlowTest extends TestCase
{
    private PushNotificationService $pushService;
    private CreditService $credits;
    private BookingService $bookings;

    protected function setUp(): void
    {
        parent::setUp();

        $this->pushService = Mockery::mock(PushNotificationService::class);
        app()->instance('firebase.messaging', new MessagingStub());

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->string('fcm_token')->nullable();
            $table->string('stripe_account_id')->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->decimal('commission_rate', 5, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('user_credits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->integer('balance')->default(0);
            $table->integer('lifetime_purchased')->default(0);
            $table->integer('lifetime_used')->default(0);
            $table->timestamp('last_purchase_at')->nullable();
            $table->timestamps();
        });

        Schema::create('credit_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('type');
            $table->integer('amount');
            $table->integer('balance_after');
            $table->string('description');
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->timestamps();
        });

        Schema::create('unlocked_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('nanny_id');
            $table->integer('credits_used');
            $table->timestamp('unlocked_at');
            $table->timestamp('expires_at')->nullable();
            $table->boolean('has_booked')->default(false);
            $table->timestamps();
        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('nanny_id');
            $table->unsignedBigInteger('agency_id')->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->integer('hours');
            $table->decimal('hourly_rate', 8, 2);
            $table->string('status')->default('requested');
            $table->timestamps();
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->string('type');
            $table->decimal('amount', 8, 2);
            $table->decimal('subtotal', 8, 2);
            $table->decimal('platform_fee', 8, 2);
            $table->decimal('agency_fee', 8, 2);
            $table->string('stripe_payment_intent_id');
            $table->string('status');
            $table->timestamp('released_at')->nullable();
            $table->timestamps();
        });

        $this->credits = new CreditService();
        $this->bookings = new BookingService(new PaymentService(), $this->pushService);
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('unlocked_profiles');
        Schema::dropIfExists('credit_transactions');
        Schema::dropIfExists('user_credits');
        Schema::dropIfExists('users');
        Mockery::close();
        parent::tearDown();
    }

    public function test_full_booking_flow()
    {
        $nanny = User::factory()->create([
            'latitude' => 51.5000,
            'longitude' => -0.1000,
            'fcm_token' => 'nanny',
            'stripe_account_id' => 'acct_nanny',
        ]);

        $parent = User::factory()->create([
            'latitude' => 51.5010,
            'longitude' => -0.1200,
            'fcm_token' => 'parent',
        ]);

        UserCredit::create([
            'user_id' => $parent->id,
            'balance' => 5,
            'lifetime_purchased' => 5,
            'lifetime_used' => 0,
        ]);

        $results = User::query()
            ->where('id', $nanny->id)
            ->nearby(['lat' => 51.5, 'lng' => -0.12], 10)
            ->get();

        $this->assertTrue($results->contains('id', $nanny->id));

        $this->credits->unlockProfile($parent, $nanny);

        $this->assertDatabaseHas('unlocked_profiles', [
            'parent_id' => $parent->id,
            'nanny_id' => $nanny->id,
        ]);

        Mockery::mock('alias:' . PaymentIntent::class)
            ->shouldReceive('create')
            ->once()
            ->andReturn((object)['id' => 'pi']);

        $this->pushService->shouldReceive('sendToDevice')->twice();

        $booking = $this->bookings->createBooking([
            'parent_id' => $parent->id,
            'nanny_id' => $nanny->id,
            'hours' => 2,
            'hourly_rate' => 20,
            'status' => Booking::STATUS_REQUESTED,
        ]);

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => Booking::STATUS_REQUESTED,
        ]);

        $booking->update(['status' => Booking::STATUS_ACCEPTED]);
        $this->assertEquals(Booking::STATUS_ACCEPTED, $booking->fresh()->status);

        Mockery::mock('alias:' . Transfer::class)
            ->shouldReceive('create')
            ->once()
            ->andReturn((object)['id' => 'tr']);

        $this->bookings->completeBooking($booking);

        $this->assertDatabaseHas('transactions', [
            'booking_id' => $booking->id,
            'status' => 'completed',
        ]);

        $this->assertEquals(Booking::STATUS_COMPLETED, $booking->fresh()->status);
    }
}
