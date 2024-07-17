<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model{
	use HasFactory, HasUuids;

	protected $fillable = [
		'name',
		'email',
		'password',
		'address',
		'phone',
		'logo'
	];

	public function categories(): BelongsToMany{
		return $this->belongsToMany(Category::class);
	}

	public function products(): HasMany{
		return $this->hasMany(Product::class);
	}
}
