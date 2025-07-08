<?php

namespace App\Livewire\Payment;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Index extends Component
{
    public $event = null;
    public $eventId;
    public $nombre_tickets = 1;
    public $telephone = '';

    protected $rules = [
        'nombre_tickets' => 'required|numeric|min:1',
        'telephone' => 'required|',
    ];

    public function mount($eventId)
    {
        $this->eventId = $eventId;
        $this->fetchEvent();
    }

    public function fetchEvent()
    {
        $response = Http::get(env('API_URL') . '/public/events/' . $this->eventId);
        if ($response->successful()) {
            $this->event = $response->json();
        } else {
            session()->flash('error', 'Erreur lors de la récupération de l\'événement.');
            $this->dispatch('show-error', message: 'Erreur lors de la récupération de l\'événement.');
        }
    }

    public function purchase()
    {
        $this->validate();

        $response = Http::withToken(session(env('API_TOKEN_NAME')))->post(
            env('API_URL') . '/payment/' . $this->eventId . '/process',
            [
                'nombre_tickets' => $this->nombre_tickets,
                'telephone' => $this->telephone,
            ]
        );

        if ($response->successful()) {
            session()->flash('success', $response->json()['message']);
            $this->dispatch('show-success', message: $response->json()['message']);
            $this->redirect(route('dashboard'));
        } else {
            $errors = $response->json()['message'] ?? 'Erreur lors du paiement.';
            session()->flash('error', $errors);
            $this->dispatch('show-error', message: $errors);
        }
    }

    public function render()
    {
        return view('livewire.payment.index');
    }
}
