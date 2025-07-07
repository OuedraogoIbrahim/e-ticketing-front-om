<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    //

    public function index()
    {
        return view('pages.backend.event.index');
    }

    public function show(Event $event)
    {
        return view('pages.backend.event.show', compact('event'));
    }
    public function create()
    {
        return view('pages.backend.event.create');
    }

    public function edit(Event $event)
    {
        return view('pages.backend.event.update', compact('event'));
    }

    public function history(Event $event)
    {
        return view('pages.backend.event.history', compact('event'));
    }
}
