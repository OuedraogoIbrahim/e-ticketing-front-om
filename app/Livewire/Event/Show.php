<?php

namespace App\Livewire\Event;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Show extends Component
{
    public $event = null;
    public $eventId;

    public function mount($eventId)
    {
        $this->eventId = $eventId;
        $this->fetchEvent();
    }

    public function fetchEvent()
    {
        $response = Http::withToken(session(env('API_TOKEN_NAME')))->get(env('API_URL') . '/events/' . $this->eventId);
        if ($response->successful()) {
            $this->event = $response->json();
        } else {
            session()->flash('error', 'Erreur lors de la récupération de l\'événement.');
            $this->dispatch('show-error', message: 'Erreur lors de la récupération de l\'événement.');
            $this->event = null;
        }
    }

    public function render()
    {
        return view('livewire.event.show');
    }
}
