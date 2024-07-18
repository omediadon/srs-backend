<?php

use App\Events\ProductAdded;
use App\Events\ProductPriceChanged;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Services\SupplierMatchingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupplierRecommendationTest extends TestCase{

	use RefreshDatabase;

	public function test_supplier_matching_service(): void{
		$category  = Category::factory()
							 ->create();
		$brand     = Brand::factory()
						  ->create(['category_id' => $category->id]);
		$supplier1 = Supplier::factory()
							 ->create();
		$supplier2 = Supplier::factory()
							 ->create();

		$supplier1->categories()
				  ->attach($category);
		$supplier2->categories()
				  ->attach($category);

		$matchingSuppliers = (new SupplierMatchingService())->getMatchingSuppliers($brand);

		$this->assertCount(2, $matchingSuppliers);
		$this->assertTrue($matchingSuppliers->contains($supplier1));
		$this->assertTrue($matchingSuppliers->contains($supplier2));
	}

	public function test_new_product_event_is_fired(): void{
		Event::fake(ProductAdded::class);

		$product = Product::factory()
						  ->create();

		Event::assertDispatched(ProductAdded::class, static function($event) use ($product){
			return $event->product->id === $product->id;
		});
	}

	public function test_price_change_event_is_fired(): void{
		Event::fake(ProductPriceChanged::class);

		$product = Product::factory()
						  ->create(['price' => 100]);
		$product->update(['price' => 150]);

		Event::assertDispatched(ProductPriceChanged::class, static function($event) use ($product){
			return $event->product->id === $product->id;
		});
	}

	// More tests are a must, but time is of the essence now!
}