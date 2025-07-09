<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class PublicEventController extends Controller
{
    //
    public function index(): View
    {
        return view('pages.frontend.events.list');
    }

    public function show(string|int $eventId): View
    {
        $event = null;
        $response = Http::get(env('API_URL') . '/public/events/' . $eventId);
        if ($response->successful()) {
            $event = $response->json();
        } else {
            session()->flash('error', 'Erreur lors de la récupération de l\'événement.');
            $event = [];
        }

        return view('pages.frontend.events.show', compact('event'));
    }
}
