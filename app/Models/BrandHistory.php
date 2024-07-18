<?php

namespace App\Models;


use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;

class BrandHistory extends Model{
	protected        $connection = 'mongodb';
	protected string $collection = 'brand_histories';

	protected $fillable = [
		'brand_id',
		'search_history',
	];

	protected $casts = [
		'search_history'  => 'array',
	];

	public function brand(): \Illuminate\Database\Eloquent\Relations\BelongsTo|BelongsTo{
		return $this->belongsTo(Brand::class);
	}
}
