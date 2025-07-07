<?php

namespace App\Livewire\Event;

use App\Models\Event;
use App\Models\EventType;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{

    use WithFileUploads;

    public $event;
    public $titre;
    public $description;
    public $photo;
    public $ville;
    public $prix;
    public $date_debut;
    public $date_fin;
    public $heure_debut;
    public $heure_fin;
    public $event_type_id;
    public $nombre_tickets;
    public $types;

    public function mount(Event $event)
    {
        $this->types = EventType::all();

        if ($event->organizer_id !== Auth::user()->organizer->id) {
            abort(403, 'Non autorisé');
        }

        $this->event = $event;
        $this->titre = $event->titre;
        $this->nombre_tickets = $event->nombre_tickets;
        $this->event_type_id = $event->event_type_id;
        $this->description = $event->description;
        $this->ville = $event->ville;
        $this->prix = $event->prix;
        $this->date_debut = $event->date_debut;
        $this->date_fin = $event->date_fin;
        $this->heure_debut = $event->heure_debut;
        $this->heure_fin = $event->heure_fin;
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
            'heure_debut' => 'required|string',
            'heure_fin' => 'nullable|string',
        ]);

        if ($this->photo) {
            $validated['photo'] = $this->photo->store('events' . Auth::user()->id, 'public');
        } else {
            unset($validated['photo']);
        }

        $this->event->update($validated);

        return redirect()->route('events.show', $this->event->id)->with('success')->with('message', 'Événement mis à jour avec succès.');
    }
    public function render()
    {
        return view('livewire.event.update');
    }
}
