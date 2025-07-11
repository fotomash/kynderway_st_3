<?php

namespace Tests\Unit;

use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

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
