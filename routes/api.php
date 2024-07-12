<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Nette\Schema\Expect;

Route::get('/welcome', function (Request $request) {
    return 'Hello world';
});
// ->middleware('auth:sanctum');

Route::apiResource('/meeting', MeetingController::class);

Route::apiResource('/user', AuthController::class);

// Route::controller(RegistrationController::class)->group(function() {
//     Route::post('/registration', 'store');
//     Route::delete('/registration/{id}', 'destroy');
// });
Route::apiResource('/registration', RegistrationController::class);

Route::controller(AuthController::class)->group(function() {
    Route::post('/user', 'store');
    Route::post('/user/signin', 'signin');
});


