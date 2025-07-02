<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\AuthentificationController;
use App\Http\Controllers\TicketController;
use App\Models\Event;
use App\Models\Organizer;

// Main Page Route
// Route::get('/', [HomePage::class, 'index'])->name('pages-home');

// locale
Route::get('/lang/{locale}', [LanguageController::class, 'swap']);

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthentificationController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthentificationController::class, 'login']);

    Route::get('/register', [AuthentificationController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthentificationController::class, 'register']);


    Route::get('/mot-de-passe-oublie', [AuthentificationController::class, 'passwordForgottenForm'])->name('password.forgotten');
    Route::post('/mot-de-passe-oublie', [AuthentificationController::class, 'passwordForgotten']);

    Route::get('/reset-password/{token}', [AuthentificationController::class, 'resetPasswordForm'])
        ->name('password.reset');

    Route::post('/reset-password', [AuthentificationController::class, 'resetPassword'])
        ->name('password.update');
    // Route::get('/mot-de-passe-oublie', [AuthentificationController::class, 'passwordForgotten'])->name('password.forgotten');

    Route::resource('tickets', TicketController::class);
    Route::resource('organisateurs', Organizer::class);
    Route::resource('events', Event::class);
});
