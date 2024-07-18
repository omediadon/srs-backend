<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierSuggestionController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
	 ->group(static function(){
		 Route::post('login', [
			 AuthController::class,
			 'login'
		 ])->name('login');
		 Route::post('logout', [
			 AuthController::class,
			 'logout'
		 ]);
		 Route::post('refresh', [
			 AuthController::class,
			 'refresh'
		 ]);
		 Route::post('me', [
			 AuthController::class,
			 'me'
		 ]);
	 });

Route::prefix('brand')
	 ->group(static function(){
		 Route::get('suggest', [
			 SupplierSuggestionController::class,
			 'getSuggestions'
		 ]);
	 });



Route::apiResource('products', ProductController::class);
