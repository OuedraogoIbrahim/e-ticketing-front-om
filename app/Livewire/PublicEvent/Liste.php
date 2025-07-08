<?php

namespace App\Livewire\PublicEvent;

use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class Liste extends Component
{
    use WithPagination;

    public $type = '';
    public $ville = '';
    public $date = '';
    public $search = '';

    public $eventTypes = [];
    public $villes = [];
    public $allEvents = [];

    public function mount()
    {
        $this->fetchEventTypes();
        $this->fetchCities();
        $this->fetchEvents();
    }

    public function fetchEventTypes()
    {
        $response = Http::get(env('API_URL') . '/public/event-types');
        if ($response->successful()) {
            $this->eventTypes = $response->json();
        } else {
            session()->flash('error', 'Erreur lors de la récupération des types d\'événements.');
        }
    }

    public function fetchCities()
    {
        $response = Http::get(env('API_URL') . '/public/cities');
        if ($response->successful()) {
            $this->villes = $response->json();
        } else {
            session()->flash('error', 'Erreur lors de la récupération des villes.');
        }
    }

    public function fetchEvents()
    {
        $response = Http::get(env('API_URL') . '/public/events');
        if ($response->successful()) {
            $this->allEvents = $response->json();
        } else {
            session()->flash('error', 'Erreur lors de la récupération des événements.');
        }
    }

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
        $filteredEvents = collect($this->allEvents);

        // Filtre par type d'événement
        if ($this->type) {
            $filteredEvents = $filteredEvents->where('event_type_id', $this->type);
        }

        // Filtre par ville
        if ($this->ville) {
            $filteredEvents = $filteredEvents->where('ville', $this->ville);
        }

        // Filtre par date
        if ($this->date) {
            $today = Carbon::today();
            if ($this->date === 'today') {
                $filteredEvents = $filteredEvents->filter(function ($event) use ($today) {
                    return Carbon::parse($event['date_debut'])->isSameDay($today);
                });
            } elseif ($this->date === 'week') {
                $filteredEvents = $filteredEvents->filter(function ($event) use ($today) {
                    $dateDebut = Carbon::parse($event['date_debut']);
                    return $dateDebut->gte($today) && $dateDebut->lte($today->copy()->addWeek());
                });
            } elseif ($this->date === 'month') {
                $filteredEvents = $filteredEvents->filter(function ($event) use ($today) {
                    $dateDebut = Carbon::parse($event['date_debut']);
                    return $dateDebut->gte($today) && $dateDebut->lte($today->copy()->addMonth());
                });
            }
        }

        // Recherche par titre
        if ($this->search) {
            $filteredEvents = $filteredEvents->filter(function ($event) {
                return stripos($event['titre'], $this->search) !== false;
            });
        }


        // Pagination manuelle
        $perPage = 6;
        $currentPage = $this->getPage();
        $total = $filteredEvents->count();
        $events = $filteredEvents->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginator = new LengthAwarePaginator(
            $events,
            $total,
            $perPage,
            $currentPage,
            ['path' => url()->current()]
        );


        return view('livewire.public-event.liste', [
            'events' => $paginator,
            'eventTypes' => $this->eventTypes,
            'villes' => $this->villes,
        ]);
    }
}
