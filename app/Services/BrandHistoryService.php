<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\BrandHistory;
use Illuminate\Foundation\Auth\User;

class BrandHistoryService{
	public function addSearchTerm(Brand|User $brand, string $searchTerm, $keep = 100): BrandHistory{
		$history = BrandHistory::firstOrCreate(['brand_id' => $brand->id]);

		$searchHistory = $history->search_history ?? [];
		array_unshift($searchHistory, [
			'term'      => $searchTerm,
			'timestamp' => now()->toDateTimeString()
		]);

		$searchHistory = array_slice($searchHistory, 0, $keep);

		$history->search_history = $searchHistory;
		$history->save();

		return $history;
	}

	public function getSearchHistory(Brand $brand): array{
		$history = BrandHistory::where('brand_id', $brand->id)
							   ->first();

		if(!$history || empty($history->search_history)){
			return [];
		}

		return $history->search_history;
	}
}