<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model{
	use HasFactory, HasUuids;

	protected $fillable = ['name'];

	public function suppliers(): BelongsToMany{
		return $this->belongsToMany(Supplier::class);
	}

	public function products(): HasMany{
		return $this->hasMany(Product::class);
	}
}
