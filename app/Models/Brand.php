<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Brand extends Model{
	use HasFactory, HasUuids;

	protected $fillable = [
		'name',
		'email',
		'password',
		'address',
		'category_id',
		'logo'
	];

	public function category(): BelongsTo{
		return $this->belongsTo(Category::class);
	}
}
