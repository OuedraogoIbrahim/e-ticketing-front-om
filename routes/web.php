<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicEventController;
use App\Http\Controllers\TicketController;

// Main Page Route
// Route::get('/', [HomePage::class, 'index'])->name('pages-home');

// locale
Route::get('/lang/{locale}', [LanguageController::class, 'swap']);

Route::get("/", function () {
    return view('pages.frontend.home');
})->name('home');

Route::get('list/events', [PublicEventController::class, 'index'])->name('list.events.index');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::resource('tickets', TicketController::class);
    Route::resource('events', EventController::class)->except(['update', 'store', 'destroy']);
    Route::get('/events/{event}/tickets', [EventController::class, 'history'])->name('events.history');
    Route::get('profile', ProfileController::class)->name('profile');

    //Voir un evenement
    Route::get("/list/events/{event}", [PublicEventController::class, 'show'])->name('list.events.show');

    //Acheter un ticket
    Route::get("tickets/purchase/{event}", PaymentController::class)->name('tickets.purchase');
});


require __DIR__ . '/auth.php';
