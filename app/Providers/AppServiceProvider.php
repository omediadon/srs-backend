<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider{
	/**
	 * Register any application services.
	 */
	public function register(): void{
		//
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void{
		// No Lazy Loading! Power of the habit
		Model::preventLazyLoading();
	}
}
