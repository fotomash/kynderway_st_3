<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;
use Mockery;

class PaymentEndpointsTest extends TestCase
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
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('users');
        Mockery::close();
        parent::tearDown();
    }

    public function test_create_intent_endpoint_returns_success(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $service = Mockery::mock(PaymentService::class);
        $service->shouldReceive('createIntent')->once()->andReturn(['id' => 'pi']);
        $this->app->instance(PaymentService::class, $service);

        $response = $this->postJson('/api/v1/payments/create-intent');

        $response->assertOk()->assertJson(['id' => 'pi']);
    }

    public function test_confirm_endpoint_returns_success(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $service = Mockery::mock(PaymentService::class);
        $service->shouldReceive('confirm')->once()->with('pi_123')->andReturn(['status' => 'succeeded']);
        $this->app->instance(PaymentService::class, $service);

        $response = $this->postJson('/api/v1/payments/confirm', ['payment_intent_id' => 'pi_123']);

        $response->assertOk()->assertJson(['status' => 'succeeded']);
    }

    public function test_refund_endpoint_returns_success(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $service = Mockery::mock(PaymentService::class);
        $service->shouldReceive('refund')->once()->with('pi_123')->andReturn(['status' => 'refunded']);
        $this->app->instance(PaymentService::class, $service);

        $response = $this->postJson('/api/v1/payments/refund', ['payment_intent_id' => 'pi_123']);

        $response->assertOk()->assertJson(['status' => 'refunded']);
    }
}
