<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/

		$categories = Category::factory(5)
							  ->create();

		Supplier::factory(10)
				->create()
				->each(function($supplier) use ($categories){
					$supplier->categories()
							 ->attach($categories->random(random_int(1, 3)));
					Product::factory(random_int(5, 10))
						   ->create([
										'supplier_id' => $supplier->id,
										'category_id' => $categories->random()->id,
									]);
				});

		Brand::factory(10)
			 ->create();
    }
}
