<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Booking;
use App\Models\Transaction;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\TestCase;
use Mockery;
use Stripe\PaymentIntent;
use Stripe\Transfer;

class PaymentProcessingTest extends TestCase
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
            $table->string('stripe_account_id')->nullable();
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

    public function test_create_escrow_payment_creates_transaction()
    {
        $nanny = User::factory()->create(['stripe_account_id' => 'acct_nanny']);
        $parent = User::factory()->create();

        $booking = Booking::create([
            'parent_id' => $parent->id,
            'nanny_id' => $nanny->id,
            'hours' => 10,
            'hourly_rate' => 20,
        ]);

        Mockery::mock('alias:'.PaymentIntent::class)
            ->shouldReceive('create')
            ->once()
            ->andReturn((object) ['id' => 'pi_test']);

        $service = new PaymentService();
        $transaction = $service->createEscrowPayment($booking);

        $this->assertDatabaseHas('transactions', [
            'booking_id' => $booking->id,
            'amount' => 230.00,
            'stripe_payment_intent_id' => 'pi_test',
        ]);

        $this->assertEquals('escrow', $transaction->type);
    }

    public function test_release_payment_completes_transaction()
    {
        $nanny = User::factory()->create(['stripe_account_id' => 'acct_nanny']);
        $parent = User::factory()->create();

        $booking = Booking::create([
            'parent_id' => $parent->id,
            'nanny_id' => $nanny->id,
            'hours' => 10,
            'hourly_rate' => 20,
        ]);

        Mockery::mock('alias:'.PaymentIntent::class)
            ->shouldReceive('create')
            ->once()
            ->andReturn((object) ['id' => 'pi_test']);

        $service = new PaymentService();
        $transaction = $service->createEscrowPayment($booking);

        Mockery::mock('alias:'.Transfer::class)
            ->shouldReceive('create')->once()->andReturn((object) ['id' => 'tr']);

        $service->releasePayment($booking);

        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'status' => 'completed',
        ]);
        $this->assertNotNull($transaction->fresh()->released_at);
    }
}
