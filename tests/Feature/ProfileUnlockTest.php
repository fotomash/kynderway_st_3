<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\CreditPackage;
use App\Models\UserCredit;
use App\Models\CreditTransaction;
use App\Models\UnlockedProfile;
use App\Services\CreditService;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\TestCase;

class ProfileUnlockTest extends TestCase
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
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('unlocked_profiles');
        Schema::dropIfExists('credit_transactions');
        Schema::dropIfExists('user_credits');
        Schema::dropIfExists('users');
        parent::tearDown();
    }

    public function test_unlock_profile_deducts_credits()
    {
        $parent = User::factory()->create();
        $nanny = User::factory()->create();

        UserCredit::create([
            'user_id' => $parent->id,
            'balance' => 5,
            'lifetime_purchased' => 5,
            'lifetime_used' => 0,
        ]);

        Event::fake();
        $service = new CreditService();
        $service->unlockProfile($parent, $nanny, 'full');

        $this->assertDatabaseHas('user_credits', [
            'user_id' => $parent->id,
            'balance' => 0,
        ]);

        $this->assertDatabaseHas('unlocked_profiles', [
            'parent_id' => $parent->id,
            'nanny_id' => $nanny->id,
        ]);

        $this->assertDatabaseHas('credit_transactions', [
            'user_id' => $parent->id,
            'type' => 'use',
            'amount' => -5,
        ]);
    }
}
