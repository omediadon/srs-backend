<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
	 ->group(static function($route){
		 Route::post('login', [
			 AuthController::class,
			 'login'
		 ]);
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

Route::get('/user', static function(){
	return response()->json(auth()->user());
})
	 ->middleware('auth:api');
