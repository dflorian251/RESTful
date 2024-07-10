<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::group(['prefix' => '/api/v1', function() {
    // Route::resource('meeting', 'MeetingController', [
    //     'expect' => ['edit', 'create']
    // ]);

    // Route::resource('meeting/registration', 'RegistrationController', [
    //     'only' => ['store', 'destroy']
    // ]);

    // Route::post('/user', [AuthController::class, 'store']);

    // Route::post('/user/signin', [AuthController::class, 'signin']);
// }]);
