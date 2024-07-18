<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SupplierSuggestion;
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
			 SupplierSuggestion::class,
			 'getSuggestions'
		 ]);
	 });

Route::get('/user', static function(){
	return response()->json(auth()->user());
})
	 ->middleware('auth:api');
