<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\UserCredit;
use App\Models\CreditTransaction;
use App\Services\CreditService;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\TestCase;

class CreditServiceTest extends TestCase
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
            $table->softDeletes();
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
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('credit_transactions');
        Schema::dropIfExists('user_credits');
        Schema::dropIfExists('users');
        parent::tearDown();
    }

    public function test_has_enough_credits_returns_true_when_balance_sufficient()
    {
        $user = User::factory()->create();
        UserCredit::create(['user_id' => $user->id, 'balance' => 5]);

        $service = new CreditService();

        $this->assertTrue($service->hasEnoughCredits($user));
    }

    public function test_has_enough_credits_returns_false_when_balance_low()
    {
        $user = User::factory()->create();
        UserCredit::create(['user_id' => $user->id, 'balance' => 1]);

        $service = new CreditService();

        $this->assertFalse($service->hasEnoughCredits($user));
    }

    public function test_deduct_credits_updates_balance_and_logs_transaction()
    {
        $user = User::factory()->create();
        UserCredit::create([
            'user_id' => $user->id,
            'balance' => 5,
            'lifetime_purchased' => 5,
            'lifetime_used' => 0,
        ]);

        Event::fake();

        $service = new CreditService();
        $service->deductCredits($user);

        $this->assertDatabaseHas('user_credits', [
            'user_id' => $user->id,
            'balance' => 2,
            'lifetime_used' => 3,
        ]);

        $this->assertDatabaseHas('credit_transactions', [
            'user_id' => $user->id,
            'type' => 'use',
            'amount' => -3,
        ]);
    }
}
