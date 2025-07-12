<?php

namespace Tests\Unit;

use App\Models\Review;
use App\Models\User;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        \Schema::create('users', function ($table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->timestamps();
        });

        \Schema::create('reviews', function ($table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->unsignedBigInteger('reviewer_id');
            $table->unsignedBigInteger('reviewee_id');
            $table->string('reviewer_type');
            $table->unsignedInteger('rating');
            $table->text('comment')->nullable();
            $table->json('rating_categories')->nullable();
            $table->boolean('would_recommend')->default(true);
            $table->boolean('would_hire_again')->default(true);
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        \Schema::dropIfExists('reviews');
        \Schema::dropIfExists('users');
        parent::tearDown();
    }

    public function test_review_can_be_created()
    {
        $reviewer = User::factory()->create();
        $reviewee = User::factory()->create();

        $review = Review::create([
            'booking_id' => 1,
            'reviewer_id' => $reviewer->id,
            'reviewee_id' => $reviewee->id,
            'reviewer_type' => 'parent',
            'rating' => 5,
            'comment' => 'Great service.',
            'rating_categories' => [
                'punctuality' => 5,
                'communication' => 5,
                'care_quality' => 5,
            ],
            'would_recommend' => true,
            'would_hire_again' => true,
        ]);

        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'reviewer_id' => $reviewer->id,
            'reviewee_id' => $reviewee->id,
        ]);
    }
}
