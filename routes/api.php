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

// Route::apiResource('/user', AuthController::class);

Route::controller(RegistrationController::class)->group(function() {
    Route::post('/registration', 'store');
    Route::delete('/registration/{id}', 'destroy');
});
// Route::group([
//     'middleware' => 'api',
//     'prefix' => 'auth'
// ], function() {
//     Route::apiResource('/registration', RegistrationController::class)->middleware('auth.api');
// });

Route::controller(AuthController::class)->group(function() {
    Route::post('/user', 'store');
    Route::post('/user/signin', 'signin');
});


// <?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\AuthController;

// Route::group([
//     'middleware' => 'api',
//     'prefix' => 'auth'
// ], function ($router) {
//     Route::post('/register', [AuthController::class, 'register'])->name('register');
//     Route::post('/login', [AuthController::class, 'login'])->name('login');
//     Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
//     Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
//     Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
// });

