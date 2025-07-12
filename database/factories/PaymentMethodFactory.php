<?php

namespace Database\Factories;

use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentMethodFactory extends Factory
{
    protected $model = PaymentMethod::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'provider' => 'stripe',
            'type' => 'card',
            'last_four' => (string) $this->faker->numberBetween(1000, 9999),
            'exp_month' => $this->faker->numberBetween(1, 12),
            'exp_year' => $this->faker->numberBetween(date('Y'), date('Y') + 5),
            'stripe_payment_method_id' => 'pm_' . $this->faker->unique()->lexify(str_repeat('?', 24)),
        ];
    }
}
