<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition()
    {
        return [
            'booking_id' => 1,
            'reviewer_id' => User::factory(),
            'reviewee_id' => User::factory(),
            'reviewer_type' => 'parent',
            'rating' => $this->faker->numberBetween(1,5),
            'comment' => $this->faker->sentence(),
            'rating_categories' => [
                'punctuality' => $this->faker->numberBetween(1,5),
                'communication' => $this->faker->numberBetween(1,5),
                'care_quality' => $this->faker->numberBetween(1,5),
            ],
            'would_recommend' => true,
            'would_hire_again' => true,
        ];
    }
}
