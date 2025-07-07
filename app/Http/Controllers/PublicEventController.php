<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicEventController extends Controller
{
    //
    public function index(): View
    {
        return view('pages.frontend.events.list');
    }

    public function show(Event $event): View
    {
        return view('pages.frontend.events.show', compact('event'));
    }
}
