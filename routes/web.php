<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\language\LanguageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicEventController;
use Illuminate\Http\Request;

// Main Page Route
// Route::get('/', [HomePage::class, 'index'])->name('pages-home');

// locale
Route::get('/lang/{locale}', [LanguageController::class, 'swap']);

Route::get("/", function () {
    return view('pages.frontend.home');
})->name('home');


Route::get('list/events', [PublicEventController::class, 'index'])->name('list.events.index');

Route::middleware('token.auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::resource('events', EventController::class)->except(['update', 'store', 'destroy']);
    Route::get('/events/{eventId}/tickets', [EventController::class, 'history'])->name('events.history');
    Route::get('profile', ProfileController::class)->name('profile');

    //Voir un evenement
    Route::get("/list/events/{eventId}", [PublicEventController::class, 'show'])->name('list.events.show');

    //Acheter un ticket
    Route::get("tickets/purchase/{eventId}", PaymentController::class)->name('tickets.purchase');
});


//Stockage du token en session
Route::post('/store-token-in-session', function (Request $request) {
    if ($request->has('token')) {
        session()->put('token-app-e-ticketing', $request->token);

        // Optionnel : stocker aussi les infos utilisateur
        if ($request->has('user')) {
            session()->put('auth_user', $request->user);
        }

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false], 400);
});

//Suppression de la session
Route::post('/clear-session', function (Request $request) {

    session()->flush();
    return response()->json(['success' => true]);
})->name('clear-session');
require __DIR__ . '/auth.php';
