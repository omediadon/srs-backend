<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\BrandHistory;
use App\Models\Supplier;

class SupplierMatchingService{

	public function getMatchingSuppliers(Brand $brand){
		// Get the brand's category
		$categoryId = $brand->category->id;

		// Get suppliers in the same category
		$suppliers = Supplier::whereHas('categories', static function($query) use ($categoryId){
			$query->where('categories.id', $categoryId);
		})
							 ->get();

		$searchTerms = (new BrandHistoryService())->getSearchHistory($brand->id);

		// If we have search history, use it to refine suggestions
		if(!empty($searchTerms)){
			$suppliers = $suppliers->sortByDesc(function($supplier) use ($searchTerms){
				$relevanceScore = 0;
				foreach($supplier->products as $product){
					foreach($searchTerms as $term){
						if(stripos($product->name, $term) !== false || stripos($product->description, $term) !== false){
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