<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\BrandHistory;
use App\Models\Supplier;
use Illuminate\Support\Facades\Log;

class SupplierMatchingService{

	public function getMatchingSuppliers(Brand $brand){
		// Get the brand's category
		$categoryId = $brand->category->id;

		// Get suppliers in the same category
		$suppliers = Supplier::with('products')->whereHas('categories', static function($query) use ($categoryId){
			$query->where('categories.id', $categoryId);
		})
							 ->get();

		$searchTerms = (new BrandHistoryService())->getSearchHistory($brand);

		// If we have search history, use it to refine suggestions
		if(!empty($searchTerms)){
			$suppliers = $suppliers->sortByDesc(function($supplier) use ($searchTerms){
				$relevanceScore = 0;
				foreach($supplier->products as $product){
					foreach($searchTerms as $term){
						$search= $term['term'];
						if(stripos($product->name, $search) !== false || stripos($product->description, $search) !== false){
							$relevanceScore++;
						}
					}
				}

				return $relevanceScore;
			});
		}

		return $suppliers;
	}
}