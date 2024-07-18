<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<Supplier>
 */
class SupplierFactory extends Factory{

	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array{
		return [
			'name'     => $this->faker->company,
			'email'    => $this->faker->unique()->safeEmail,
			'password' => Hash::make('password'),
			'address'  => $this->faker->address,
			'phone'    => $this->faker->phoneNumber,
			'logo'     => $this->faker->imageUrl(),
		];
	}
}
