<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array{
		$colors = [
			'red',
			'blue',
			'green',
			'yellow',
			'purple',
			'pink',
			'black',
			'white'
		];

		return [
			'name'         => $this->faker->word,
			'description'  => $this->faker->sentence,
			'category_id'  => Category::factory(),
			'supplier_id'  => Supplier::factory(),
			'colors'       => $this->faker->randomElements($colors, $this->faker->numberBetween(1, 3)),
			'visibility'   => $this->faker->boolean,
			'price'        => $this->faker->randomFloat(2, 10, 1000),
			'main_picture' => $this->faker->imageUrl(),
		];
	}
}
