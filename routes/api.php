<?php

use Illuminate\Support\Facades\Route;

/*Route::get('/bulk-onboard', function () {
	return view('welcome');
});*/
Route::post('/bulk-onboard', [\App\Http\Controllers\Organizations\OnboardingController::class, 'index']);