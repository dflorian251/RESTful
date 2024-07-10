<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MeetingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Nette\Schema\Expect;

Route::get('/welcome', function (Request $request) {
    return 'Hello world';
});
// ->middleware('auth:sanctum');



Route::controller(MeetingController::class)->group(function () {
    Route::get('/meeting' , 'index');
    Route::post('/meeting' , 'store');
    Route::get('/meeting/{id}' , 'show');
    Route::put('/meeting/{id}' , 'update');
    Route::delete('/meeting/{id}' , 'destroy');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/user/signup', 'store');
    Route::get('/user/signin', 'signin');
});
