<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
	/**
	 * Define the model's default state.
	 */
	public function definition(): array
	{
		return [
			'name' => $this->faker->name(),
			'email' => $this->faker->unique()->safeEmail(),
			'password' => 'test1234',
			'user_id' => Admin::factory(),
			'user_type' => Admin::class,
		];
	}

	public function inactive(): static
	{
		return $this->state(function (array $attributes) {
			return [
				'active' => false,
			];
		});
	}
}
