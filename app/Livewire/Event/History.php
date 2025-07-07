<?php

namespace App\Livewire\Event;

use App\Models\Event;
use Carbon\Carbon;
use Livewire\Component;

class History extends Component
{
    public $event;
    public $eventStatus;
    public $stats;

    public function mount(Event $event)
    {
        // if ($event->organizer_id !== Auth::user()->organizer->id) {
        //     abort(403, 'Non autorisé');
        // }

        $this->event = $event;

        // Calculer l'état de l'événement
        $now = Carbon::now();
        $dateDebut = Carbon::parse($event->date_debut . ' ' . $event->heure_debut);
        $dateFin = Carbon::parse($event->date_fin . ' ' . ($event->heure_fin ?? '23:59:59'));

        if ($now->lessThan($dateDebut)) {
            $this->eventStatus = ['text' => 'Pas encore commencé', 'class' => 'bg-info'];
        } elseif ($now->between($dateDebut, $dateFin)) {
            $this->eventStatus = ['text' => 'En cours', 'class' => 'bg-success'];
        } else {
            $this->eventStatus = ['text' => 'Terminé', 'class' => 'bg-danger'];
        }

        // Calculer les statistiques des tickets
        $this->stats = [
            'totalTickets' => $event->tickets()->sum("nombre"),
            'transferredTickets' => $event->ticket_transfers()->count(),
            'usedTickets' => $event->tickets()->whereNotNull('date_utilisation')->count(),
            'remainingTickets' => $event->nombre_tickets - $event->tickets()->sum("nombre"),
        ];
    }
    public function render()
    {
        return view('livewire.event.history');
    }
}
