<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;

class Client extends Component
{
    use WithPagination;

    public $ticketsCount = [];
    public $stats = [
        'tickets_total' => 0,
        'tickets_non_utilises' => 0,
        'tickets_transferes' => 0,
    ];
    public $ticket = null;
    public $phone = '';
    public $quantity = 1;

    public function mount()
    {
        $this->fetchStats();
        $this->fetchTicketsCount();
    }

    public function fetchStats()
    {
        $response = Http::withToken(session(env('API_TOKEN_NAME')))->get(env('API_URL') . '/client/stats');
        if ($response->successful()) {
            $this->stats = $response->json();
        } else {
            session()->flash('error', 'Erreur lors de la récupération des statistiques.');
            $this->dispatch('show-error', message: 'Erreur lors de la récupération des statistiques.');
        }
    }

    public function fetchTicketsCount()
    {
        $response = Http::withToken(session(env('API_TOKEN_NAME')))->get(env('API_URL') . '/client/events');
        if ($response->successful()) {
            $this->ticketsCount = $response->json()['data'];
        } else {
            session()->flash('error', 'Erreur lors de la récupération des tickets.');
            $this->dispatch('show-error', message: 'Erreur lors de la récupération des tickets.');
        }
    }

    public function openTransferModal($ticketId)
    {
        $response = Http::withToken(session(env('API_TOKEN_NAME')))->get(env('API_URL') . '/client/tickets/' . $ticketId);
        if ($response->successful()) {
            $this->ticket = $response->json();
            $this->phone = '';
            $this->quantity = 1;
        } else {
            session()->flash('error', 'Erreur lors de la récupération du ticket.');
            $this->dispatch('show-error', message: 'Erreur lors de la récupération du ticket.');
        }
    }

    public function transferTicket($ticketId)
    {
        $response = Http::withToken(session(env('API_TOKEN_NAME')))->post(env('API_URL') . '/client/tickets/' . $ticketId . '/transfer', [
            'phone' => $this->phone,
            'quantity' => $this->quantity,
        ]);

        if ($response->successful()) {
            session()->flash('success', $response->json()['message']);
            $this->dispatch('show-success', message: $response->json()['message']);
            $this->fetchStats(); // Rafraîchir les statistiques
            $this->fetchTicketsCount(); // Rafraîchir la liste des tickets
            $this->reset(['ticket', 'phone', 'quantity']);
            $this->dispatch('close-modal'); // Fermer le modal
        } else {
            $errors = $response->json()['message'] ?? 'Erreur lors du transfert.';
            session()->flash('error', $errors);
            $this->dispatch('show-error', message: $errors);
        }
    }

    public function downloadTicket($eventId)
    {
        $response = Http::withToken(session(env('API_TOKEN_NAME')))->get(env('API_URL') . '/client/events/' . $eventId . '/download-ticket');

        if ($response->successful()) {
            return response()->streamDownload(function () use ($response) {
                echo $response->body();
            }, 'ticket-event-' . $eventId . '.pdf');
        } else {
            session()->flash('error', $response->json()['message'] ?? 'Erreur lors du téléchargement du ticket.');
            $this->dispatch('show-error', message: $response->json()['message'] ?? 'Erreur lors du téléchargement du ticket.');
        }
    }

    public function render()
    {
        $response = Http::withToken(session(env('API_TOKEN_NAME')))->get(env('API_URL') . '/client/events?page=' . $this->getPage());
        $events = $response->successful() ? $response->json() : ['data' => [], 'links' => [], 'meta' => []];

        return view('livewire.dashboard.client', [
            'events' => $events['data'],
            'links' => $events['links'],
        ]);
    }
}
