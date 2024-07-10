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



Route::controller(MeetingController::class)->group(function() {
    Route::get('/meeting' , 'index');
    Route::post('/meeting' , 'store');
    Route::get('/meeting/{id}' , 'show');
    Route::put('/meeting/{id}' , 'update');
    Route::delete('/meeting/{id}' , 'destroy');
});

Route::controller(AuthController::class)->group(function() {
    Route::post('/user', 'store');
    Route::get('/user/{email}&{password}', 'signin');
});

Route::controller(RegistrationController::class)->group(function() {
    Route::post('/registration', 'store');
    Route::delete('/registration/{id}', 'destroy');
});
