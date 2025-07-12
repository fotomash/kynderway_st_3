<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\CreditPackage;
use App\Models\UserCredit;
use App\Models\CreditTransaction;
use App\Services\CreditService;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Tests\TestCase;

class CreditPurchaseTest extends TestCase
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

        Schema::create('credit_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('credits');
            $table->decimal('price', 8, 2);
            $table->decimal('price_per_credit', 8, 4)->nullable();
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('credit_packages');
        Schema::dropIfExists('users');
        parent::tearDown();
    }

    public function test_purchase_credits_updates_balance()
    {
        $user = User::factory()->create();
        $package = CreditPackage::create([
            'name' => 'Starter',
            'credits' => 10,
            'price' => 10.00,
            'price_per_credit' => 1.00,
        ]);

        Event::fake();
        $service = new CreditService();
        $service->purchaseCredits($user, $package, 10);

        $this->assertDatabaseHas('user_credits', [
            'user_id' => $user->id,
            'balance' => 10,
        ]);

        $this->assertDatabaseHas('credit_transactions', [
            'user_id' => $user->id,
            'type' => 'purchase',
            'amount' => 10,
        ]);
    }
}
