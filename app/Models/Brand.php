<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Brand extends Authenticatable implements JWTSubject{
	use HasFactory, HasUuids, Notifiable;

	protected $fillable = [
		'name',
		'email',
		'password',
		'address',
		'category_id',
		'logo'
	];
	protected $hidden = [
		'password',
	];

	public function category(): BelongsTo{
		return $this->belongsTo(Category::class);
	}

	public function getJWTIdentifier(){
		return $this->getKey();
	}

	public function getJWTCustomClaims(): array{
		return [];
	}
}
