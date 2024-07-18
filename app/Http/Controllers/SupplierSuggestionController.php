<?php

namespace App\Http\Controllers;

use App\Models\BrandHistory;
use App\Models\Supplier;
use App\Services\SupplierMatchingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\Middleware;

class SupplierSuggestionController extends Controller{
	public static function middleware(): array{

		return [
			new Middleware('auth:brand')
		];
	}

	public function getSuggestions(): JsonResponse{
		$brand = auth('brand')->user();

		$suppliers = (new SupplierMatchingService())->getMatchingSuppliers($brand);

		// You might want to paginate the results
		return response()->json([
									'suggestions' => $suppliers->take(10)
															   ->values()
															   ->all()
								]);
	}
}
