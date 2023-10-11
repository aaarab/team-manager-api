<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employer>
 */
class EmployerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $account = Account::inRandomOrder()->first();

        return [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'account_id' => $account->id,
            'status' => fake()->randomElement(['draft', 'valid', 'cancelled']),
        ];
    }
}
