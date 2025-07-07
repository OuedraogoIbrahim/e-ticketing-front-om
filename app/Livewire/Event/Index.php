<?php

namespace App\Livewire\Event;

use App\Models\Event;
use App\Models\EventType;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    // public $searchTitre = '';
    public $searchVille = '';
    public $searchPrixMin = '';
    public $searchDateDebut = '';
    public $searchType;

    public $types = [];

    use WithPagination;

    public function mount()
    {
        $this->types = EventType::all();
    }
    public function deleteEvent($id)
    {
        $event = Event::query()->findOrFail($id);
        $event->delete();
    }
    public function render()
    {
        $query = Event::query()->where('organizer_id', Auth::user()->organizer->id);

        if ($this->searchType) {
            $query->where('event_type_id',  $this->searchType);
        }

        if ($this->searchVille) {
            $query->where('ville', 'like', '%' . $this->searchVille . '%');
        }

        if ($this->searchPrixMin) {
            $query->where('prix', '>=', $this->searchPrixMin);
        }

        if ($this->searchDateDebut) {
            $query->where('date_debut', '>=', $this->searchDateDebut);
        }
        $events  = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.event.index', compact('events'));
    }
}
