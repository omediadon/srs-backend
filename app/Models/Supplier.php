<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Supplier extends Authenticatable implements JWTSubject{
	use HasFactory, HasUuids, Notifiable;

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

	public function getJWTIdentifier(){
		return $this->getKey();
	}

	public function getJWTCustomClaims(){
		return [];
	}
}
