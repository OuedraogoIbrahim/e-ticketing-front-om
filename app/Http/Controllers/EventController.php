<?php

namespace App\Http\Controllers;


class EventController extends Controller
{
    //

    public function index()
    {
        return view('pages.backend.event.index');
    }


    public function show(string $eventId)
    {
        return view('pages.backend.event.show', compact('eventId'));
    }
    public function create()
    {
        return view('pages.backend.event.create');
    }

    public function edit(string $eventId)
    {
        return view('pages.backend.event.update', compact('eventId'));
    }

    public function history(string $eventId)
    {
        return view('pages.backend.event.history', compact('eventId'));
    }
}
