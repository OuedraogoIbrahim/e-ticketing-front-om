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
    public $perPage = 10;

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
        $params = [
            'per_page' => $this->perPage,
            'page' => $this->getPage(),
            'type' => $this->type,
            'ville' => $this->ville,
            'date' => $this->date,
            'search' => $this->search
        ];

        $response = Http::get(env('API_URL') . '/public/events', array_filter($params));

        if ($response->successful()) {
            return $response->json();
        }

        session()->flash('error', 'Erreur lors de la récupération des événements.');
        return ['data' => [], 'meta' => []];
    }
    public function resetFilters()
    {
        $this->type = '';
        $this->ville = '';
        $this->date = '';
        $this->search = '';
        $this->resetPage();
    }

    // public function search()
    // {
    //     $this->resetPage();
    // }

    public function render()
    {
        $data = $this->fetchEvents();

        return view('livewire.public-event.liste', [
            'events' => $data['data'] ?? [],
            'pagination' => $data['meta'] ?? null,
            'eventTypes' => $this->fetchEventTypes(),
            'villes' => $this->fetchCities()
        ]);
    }
}
