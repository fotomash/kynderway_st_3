<?php

namespace Tests\Unit;

require_once __DIR__ . '/../Stubs/FirebaseStubs.php';

use App\Models\Booking;
use App\Models\User;
use App\Services\BookingService;
use App\Services\PaymentService;
use App\Services\PushNotificationService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mockery;
use Stripe\PaymentIntent;
use Stripe\Transfer;
use Tests\TestCase;

class BookingServiceTest extends TestCase
{
    private $pushService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->pushService = Mockery::mock(PushNotificationService::class);
        app()->instance(PushNotificationService::class, $this->pushService);

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->string('stripe_account_id')->nullable();
            $table->string('fcm_token')->nullable();
            $table->decimal('commission_rate', 5, 2)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('nanny_id');
            $table->unsignedBigInteger('agency_id')->nullable();
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
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('users');
        Mockery::close();
        parent::tearDown();
    }

    public function test_create_booking_creates_transaction()
    {
        $nanny = User::factory()->create(['fcm_token' => 'nanny']);
        $parent = User::factory()->create(['fcm_token' => 'parent']);

        Mockery::mock('alias:' . PaymentIntent::class)
            ->shouldReceive('create')
            ->once()
            ->andReturn((object) ['id' => 'pi_test']);

        $this->pushService->shouldReceive('sendToDevice')->once();
        $service = new BookingService(new PaymentService(), $this->pushService);
        $booking = $service->createBooking([
            'parent_id' => $parent->id,
            'nanny_id' => $nanny->id,
            'hours' => 2,
            'hourly_rate' => 20,
            'status' => Booking::STATUS_REQUESTED,
        ]);

        $this->assertDatabaseHas('transactions', [
            'booking_id' => $booking->id,
            'stripe_payment_intent_id' => 'pi_test',
        ]);
    }

    public function test_complete_booking_updates_transaction()
    {
        $nanny = User::factory()->create([
            'stripe_account_id' => 'acct_nanny',
            'fcm_token' => 'nanny'
        ]);
        $parent = User::factory()->create(['fcm_token' => 'parent']);

        Mockery::mock('alias:' . PaymentIntent::class)
            ->shouldReceive('create')
            ->once()
            ->andReturn((object) ['id' => 'pi_test']);

        $this->pushService->shouldReceive('sendToDevice')->twice();
        $service = new BookingService(new PaymentService(), $this->pushService);
        $booking = $service->createBooking([
            'parent_id' => $parent->id,
            'nanny_id' => $nanny->id,
            'hours' => 3,
            'hourly_rate' => 30,
            'status' => Booking::STATUS_REQUESTED,
        ]);

        Mockery::mock('alias:' . Transfer::class)
            ->shouldReceive('create')
            ->once()
            ->andReturn((object) ['id' => 'tr_test']);

        $service->completeBooking($booking);

        $this->assertDatabaseHas('transactions', [
            'booking_id' => $booking->id,
            'status' => 'completed',
        ]);
        $this->assertEquals(Booking::STATUS_COMPLETED, $booking->fresh()->status);
    }
}
