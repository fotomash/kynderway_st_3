<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        return [
            'booking_id' => Booking::factory(),
            'stripe_payment_intent_id' => 'pi_' . $this->faker->lexify(str_repeat('?', 24)),
            'status' => 'pending',
        ];
    }
}
