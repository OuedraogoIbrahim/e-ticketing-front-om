<?php

namespace App\Livewire\Event;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;

class Index extends Component
{
    use WithPagination;

    public $searchVille = '';
    public $searchPrixMin = '';
    public $searchDateDebut = '';
    public $searchType = '';

    public $types = [];
    public $allEvents = [];

    public function mount()
    {
        $this->fetchEventTypes();
        $this->fetchEvents();
    }

    public function fetchEventTypes()
    {
        $response = Http::get(env('API_URL') . '/public/event-types');
        if ($response->successful()) {
            $this->types = $response->json();
        } else {
            session()->flash('error', 'Erreur lors de la récupération des types d\'événements.');
            $this->dispatch('show-error', message: 'Erreur lors de la récupération des types d\'événements.');
        }
    }

    public function fetchEvents()
    {
        $response = Http::withToken(session(env('API_TOKEN_NAME')))->get(env('API_URL') . '/events');
        if ($response->successful()) {
            $this->allEvents = $response->json();
        } else {
            session()->flash('error', 'Erreur lors de la récupération des événements.');
            $this->dispatch('show-error', message: 'Erreur lors de la récupération des événements.');
        }
    }

    public function deleteEvent($id)
    {
        $response = Http::withToken(session(env('API_TOKEN_NAME')))->delete(env('API_URL') . '/events/' . $id);
        if ($response->successful()) {
            $this->allEvents = array_filter($this->allEvents, fn($event) => $event['id'] !== $id);
            session()->flash('message', $response->json()['message']);
            $this->dispatch('show-success', message: $response->json()['message']);
        } else {
            session()->flash('error', $response->json()['message'] ?? 'Erreur lors de la suppression de l\'événement.');
            $this->dispatch('show-error', message: $response->json()['message'] ?? 'Erreur lors de la suppression de l\'événement.');
        }
    }

    public function render()
    {
        $filteredEvents = collect($this->allEvents);

        // Filtre par type d'événement
        if ($this->searchType) {
            $filteredEvents = $filteredEvents->where('event_type_id', $this->searchType);
        }

        // Filtre par ville
        if ($this->searchVille) {
            $filteredEvents = $filteredEvents->filter(function ($event) {
                return stripos($event['ville'], $this->searchVille) !== false;
            });
        }

        // Filtre par prix minimum
        if ($this->searchPrixMin) {
            $filteredEvents = $filteredEvents->where('prix', '>=', $this->searchPrixMin);
        }

        // Filtre par date de début
        if ($this->searchDateDebut) {
            $filteredEvents = $filteredEvents->filter(function ($event) {
                return Carbon::parse($event['date_debut'])->gte(Carbon::parse($this->searchDateDebut));
            });
        }

        // Pagination manuelle
        $perPage = 10;
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

        return view('livewire.event.index', [
            'events' => $events,
            'paginator' => $paginator,
        ]);
    }
}
