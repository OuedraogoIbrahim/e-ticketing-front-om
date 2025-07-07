<?php

namespace App\Livewire\Event;

use App\Models\Event;
use App\Models\EventType;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{

    use WithFileUploads;

    public $titre = '';
    public $description;
    public $photo;
    public $ville = '';
    public $prix = '';
    public $date_debut = '';
    public $date_fin = '';
    public $heure_debut = '';
    public $heure_fin = '';
    public $event_type_id;
    public $nombre_tickets;
    public $types;

    public function mount()
    {
        $this->types = EventType::all();
    }

    public function submit()
    {
        $validated = $this->validate([
            'titre' => 'required|string|max:255',
            'nombre_tickets' => 'required|numeric',
            'event_type_id' => 'required|exists:event_types,id',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'ville' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
        ]);

        if ($this->photo) {
            $validated['photo'] = $this->photo->store('events/' . Auth::user()->id, 'public');
        }

        $validated['organizer_id'] = Auth::user()->organizer->id;

        $event = Event::create($validated);

        // Rediriger vers la route events.edit
        return redirect()->route('events.show', $event->id)->with('message', 'Événement créé avec succès.');
    }
    public function render()
    {
        return view('livewire.event.create');
    }
}
