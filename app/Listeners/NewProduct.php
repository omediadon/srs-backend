<?php

namespace App\Listeners;

use App\Events\ProductAdded;
use App\Mail\NewProductNotification;
use App\Models\Brand;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class NewProduct implements ShouldQueue{
	/**
	 * Create the event listener.
	 */
	public function __construct(){
		//
	}

	/**
	 * Handle the event.
	 */
	public function handle(ProductAdded $event): void{
		$product          = $event->product;
		// Get the list of brands "subscribed" to this category_id
		$interestedBrands = Brand::where('category_id', $product->category_id)
								 ->get();

		foreach($interestedBrands as $brand){
			Mail::to($brand->email)
				->queue(new NewProductNotification($brand, $product));
		}
	}
}
