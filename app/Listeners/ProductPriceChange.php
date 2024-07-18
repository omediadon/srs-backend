<?php

namespace App\Listeners;

use App\Events\ProductPriceChanged;
use App\Models\Brand;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class ProductPriceChange implements ShouldQueue{
	/**
	 * Create the event listener.
	 */
	public function __construct(){
		//
	}

	/**
	 * Handle the event.
	 */
	public function handle(ProductPriceChanged $event): void{
		$product          = $event->product;
		$interestedBrands = Brand::where('category_id', $product->category_id)
								 ->get();

		foreach($interestedBrands as $brand){
			Mail::to($brand->email)
				 ->queue(new PriceChangeNotification($brand, $product, $event->oldPrice, $event->currentPrice));
		}
	}
}
