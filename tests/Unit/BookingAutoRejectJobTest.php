<?php

namespace Tests\Unit;

use App\Jobs\BookingAutoRejectJob;
use App\Models\Booking;
use App\Models\User;
use App\Services\PushNotificationService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mockery;
use Tests\TestCase;

require_once __DIR__ . '/../Stubs/FirebaseStubs.php';

class BookingAutoRejectJobTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
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
            $table->string('status')->default('requested');
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('users');
        Mockery::close();
        parent::tearDown();
    }

    public function test_job_rejects_booking_and_notifies_parent()
    {
        $parent = User::factory()->create(['fcm_token' => 'parent']);
        $nanny = User::factory()->create(['fcm_token' => 'nanny']);
        $booking = Booking::create([
            'parent_id' => $parent->id,
            'nanny_id' => $nanny->id,
            'status' => Booking::STATUS_REQUESTED,
        ]);

        $service = Mockery::mock(PushNotificationService::class);
        $service->shouldReceive('sendToDevice')->once();
        app()->instance(PushNotificationService::class, $service);

        $job = new BookingAutoRejectJob($booking);
        $job->handle();

        $this->assertEquals(Booking::STATUS_REJECTED, $booking->fresh()->status);
    }
}
