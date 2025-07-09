<?php

namespace App\Livewire\Event;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class History extends Component
{
    public $event;
    public $eventStatus;
    public $stats;

    public function mount(string $eventId)
    {
        $response = Http::withToken(session(env('API_TOKEN_NAME')))
            ->get(env('API_URL') . '/history/' . $eventId . '/tickets');

        if ($response->successful()) {
            $data = $response->json();
            $this->event = $data['event'];
            $this->stats = $data['stats'];

            // Calculer l'état de l'événement
            $now = Carbon::now();
            $dateDebut = Carbon::parse($this->event['date_debut'] . ' ' . $this->event['heure_debut']);
            $dateFin = Carbon::parse($this->event['date_fin'] . ' ' . ($this->event['heure_fin'] ?? '23:59:59'));

            if ($now->lessThan($dateDebut)) {
                $this->eventStatus = ['text' => 'Pas encore commencé', 'class' => 'bg-info'];
            } elseif ($now->between($dateDebut, $dateFin)) {
                $this->eventStatus = ['text' => 'En cours', 'class' => 'bg-success'];
            } else {
                $this->eventStatus = ['text' => 'Terminé', 'class' => 'bg-danger'];
            }

            // Calculer les billets restants
            $this->stats['remaining_tickets'] = $this->event['nombre_tickets'] - $this->stats['total_tickets'];
        } else {
            session()->flash('error', 'Erreur lors de la récupération de l\'événement.');
            $this->dispatch('show-error', message: 'Erreur lors de la récupération de l\'événement.');
        }
    }
    public function render()
    {
        return view('livewire.event.history');
    }
}
