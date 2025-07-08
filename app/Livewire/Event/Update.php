<?php

namespace App\Livewire\Event;

use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithFileUploads;

class Update extends Component
{
    use WithFileUploads;

    public $event = null;
    public $eventId;
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
    public $types = [];

    public function mount($eventId)
    {
        $this->eventId = $eventId;
        $this->fetchEventTypes();
        $this->fetchEvent();
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

    public function fetchEvent()
    {
        $response = Http::withToken(session(env('API_TOKEN_NAME')))->get(env('API_URL') . '/events/' . $this->eventId);
        if ($response->successful()) {
            $this->event = $response->json();
            $this->titre = $this->event['titre'];
            $this->description = $this->event['description'];
            $this->ville = $this->event['ville'];
            $this->prix = $this->event['prix'];
            $this->date_debut = $this->event['date_debut'];
            $this->date_fin = $this->event['date_fin'];
            $this->heure_debut = $this->event['heure_debut'];
            $this->heure_fin = $this->event['heure_fin'];
            $this->event_type_id = $this->event['event_type_id'];
            $this->nombre_tickets = $this->event['nombre_tickets'];
        } else {
            session()->flash('error', 'Erreur lors de la récupération de l\'événement.');
            $this->dispatch('show-error', message: 'Erreur lors de la récupération de l\'événement.');
            $this->event = null;
        }
    }

    public function submit()
    {
        $validated = $this->validate([
            'titre' => 'required|string|max:255',
            'nombre_tickets' => 'required|numeric|min:1',
            'event_type_id' => 'required|exists:event_types,id',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'ville' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'heure_debut' => 'required|string',
            'heure_fin' => 'nullable|string',
        ]);

        $data = $validated;
        if ($this->photo) {
            $data['photo'] = $this->photo;
        } else {
            unset($data['photo']);
        }

        $response = Http::withToken(session(env('API_TOKEN_NAME')))
            ->asMultipart()
            ->when($this->photo, function ($http) use ($data) {
                return $http->attach('photo', file_get_contents($this->photo->getRealPath()), $this->photo->getClientOriginalName());
            })
            ->post(env('API_URL') . '/events' . '/' . $this->eventId, $data);


        if ($response->successful()) {
            session()->flash('success', $response->json()['message'] ?? "L'événement a bien été mis à jour.");
            $this->dispatch('show-success', message: $response->json()['message'] ?? "L'événement a bien été mis à jour.");
            $this->redirect(route('events.show', $this->eventId));
        } else {
            $errors = $response->json()['message'] ?? 'Erreur lors de la mise à jour de l\'événement.';
            session()->flash('error', $errors);
            $this->dispatch('show-error', message: $errors);
        }
    }

    public function render()
    {
        return view('livewire.event.update');
    }
}
