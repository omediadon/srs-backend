<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model{
	use HasFactory, HasUuids;

	protected $fillable = [
		'name',
		'description',
		'category_id',
		'supplier_id',
		'colors',
		'visibility',
		'price',
		'main_picture'
	];

	protected $casts = [
		'colors'     => 'array',
		'visibility' => 'boolean',
		'price'      => 'float',
	];

	public function category(): BelongsTo{
		return $this->belongsTo(Category::class);
	}

	public function supplier(): BelongsTo{
		return $this->belongsTo(Supplier::class);
	}
}
