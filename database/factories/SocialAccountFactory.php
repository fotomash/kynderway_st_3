<?php

namespace Database\Factories;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SocialAccountFactory extends Factory
{
    protected $model = SocialAccount::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'provider' => $this->faker->randomElement(['google', 'facebook']),
            'provider_id' => (string) Str::uuid(),
            'token' => $this->faker->sha256,
            'refresh_token' => $this->faker->sha256,
            'expires_at' => now()->addDay(),
        ];
    }
}
