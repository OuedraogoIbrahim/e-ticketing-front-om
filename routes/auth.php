<?php

use App\Http\Controllers\AuthentificationController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest-user')->group(function () {

    Route::get('/login', [AuthentificationController::class, 'loginForm'])->name('login');

    Route::get('/register', [AuthentificationController::class, 'registerForm'])->name('register');


    // Route::get('/mot-de-passe-oublie', [AuthentificationController::class, 'passwordForgottenForm'])->name('password.forgotten');
    // Route::post('/mot-de-passe-oublie', [AuthentificationController::class, 'passwordForgotten']);

    // Route::get('/reset-password/{token}', [AuthentificationController::class, 'resetPasswordForm'])
    //     ->name('password.reset');

    // Route::post('/reset-password', [AuthentificationController::class, 'resetPassword'])
    //     ->name('password.update');
    // Route::get('/mot-de-passe-oublie', [AuthentificationController::class, 'passwordForgotten'])->name('password.forgotten');


});


Route::middleware('auth-user')->group(function () {
    Route::post('logout', [AuthentificationController::class, 'logout'])->name('logout');
});
