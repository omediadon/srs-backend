<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array{

		return [
			'name' => $this->faker->company,
			'email' => $this->faker->unique()->safeEmail,
			'password' => Hash::make('password'),
			'address' => $this->faker->address,
			'category_id' => Category::factory(),
			'logo' => $this->faker->imageUrl(),
		];
	}
}
