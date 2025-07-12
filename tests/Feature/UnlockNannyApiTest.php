<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserCredit;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UnlockNannyApiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        Schema::create('user_credits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->integer('balance')->default(0);
            $table->integer('lifetime_purchased')->default(0);
            $table->integer('lifetime_used')->default(0);
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

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reviewer_id');
            $table->unsignedBigInteger('reviewee_id');
            $table->unsignedInteger('rating');
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('credit_transactions');
        Schema::dropIfExists('user_credits');
        Schema::dropIfExists('users');
        parent::tearDown();
    }

    public function test_unlock_endpoint_returns_sanitized_nanny_data(): void
    {
        $parent = User::factory()->create();
        $nanny = User::factory()->create(['name' => 'Nanny']);

        \DB::table('reviews')->insert([
            'reviewer_id' => $parent->id,
            'reviewee_id' => $nanny->id,
            'rating' => 4,
        ]);

        UserCredit::create([
            'user_id' => $parent->id,
            'balance' => 3,
            'lifetime_purchased' => 3,
            'lifetime_used' => 0,
        ]);

        $response = $this
            ->withoutMiddleware(\App\Http\Middleware\JwtMiddleware::class)
            ->actingAs($parent)
            ->postJson('/api/v1/unlock-nanny/'.$nanny->id);

        $response->assertOk()->assertJsonStructure([
            'success',
            'nanny' => ['id', 'name', 'rating'],
            'remaining_credits',
        ]);

        $response->assertJson([
            'success' => true,
            'nanny' => [
                'id' => $nanny->id,
                'name' => 'Nanny',
                'rating' => 4.0,
            ],
            'remaining_credits' => 0,
        ]);
    }
}
