<?php

namespace App\Livewire\PublicEvent;

use App\Models\Event;
use App\Models\EventType;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Liste extends Component
{
    use WithPagination;

    public $type = '';
    public $ville = '';
    public $date = '';
    public $search = '';

    public function resetFilters()
    {
        $this->type = '';
        $this->ville = '';
        $this->date = '';
        $this->search = '';
        $this->resetPage();
    }
    public function render()
    {
        $query = Event::query()
            ->where('date_debut', '>', Carbon::today())
            ->with('type');

        // Filtre par type d'événement
        if ($this->type) {
            $query->where('event_type_id', $this->type);
        }

        // Filtre par ville
        if ($this->ville) {
            $query->where('ville', $this->ville);
        }

        // Filtre par date
        if ($this->date) {
            if ($this->date === 'today') {
                $query->whereDate('date_debut', Carbon::today());
            } elseif ($this->date === 'week') {
                $query->whereBetween('date_debut', [Carbon::today(), Carbon::today()->addWeek()]);
            } elseif ($this->date === 'month') {
                $query->whereBetween('date_debut', [Carbon::today(), Carbon::today()->addMonth()]);
            }
        }

        // Recherche par titre
        if ($this->search) {
            $query->where('titre', 'like', '%' . $this->search . '%');
        }

        $events = $query->orderBy('date_debut', 'asc')->paginate(6);
        $eventTypes = EventType::all()->pluck('nom', 'id');
        $villes = Event::distinct()->pluck('ville');

        return view('livewire.public-event.liste', compact('events', 'eventTypes', 'villes'));
    }
}
