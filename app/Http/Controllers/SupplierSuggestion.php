<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\BrandHistory;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class SupplierSuggestion extends Controller{
	public static function middleware(): array{

		return [
			new Middleware('auth:brand')
		];
	}

	public function getSuggestions(Request $request){
		$brand        = auth()->user();
		$brandHistory = BrandHistory::where('brand_id',$brand->id )
									->first();

		// Get the brand's category
		$categoryId = $brand->category->id;

		// Get suppliers in the same category
		$suppliers = Supplier::whereHas('categories', static function($query) use ($categoryId){
			$query->where('categories.id', $categoryId);
		})
							 ->get();

		// If we have search history, use it to refine suggestions
		if($brandHistory && !empty($brandHistory->search_history)){
			$searchTerms = $brandHistory->search_history;

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

		// You might want to paginate the results
		return response()->json([
									'suggestions' => $suppliers->take(10)
															   ->values()
															   ->all()
								]);
	}
}
