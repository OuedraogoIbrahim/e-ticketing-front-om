<?php

namespace App\Livewire\Event;

use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $titre = '';
    public $description = '';
    public $photo;
    public $ville = '';
    public $prix = '';
    public $date_debut = '';
    public $date_fin = '';
    public $heure_debut = '';
    public $heure_fin = '';
    public $event_type_id = '';
    public $nombre_tickets = '';
    public $types = [];
    public $type_autre = '';
    public $autreTypeId = ''; // Stockera l'ID du type "Autre" s'il est choisit


    public function mount()
    {
        $this->fetchEventTypes();
    }

    public function fetchEventTypes()
    {
        $response = Http::get(env('API_URL') . '/public/event-types');
        if ($response->successful()) {
            $this->types = $response->json();
            $this->autreTypeId = collect($this->types)->search('autre');
        } else {
            session()->flash('error', 'Erreur lors de la récupération des types d\'événements.');
            $this->dispatch('show-error', message: 'Erreur lors de la récupération des types d\'événements.');
        }
    }

    public function submit()
    {
        $validated = $this->validate([
            'titre' => 'required|string|max:255',
            'nombre_tickets' => 'required|numeric|min:1',
            'event_type_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!array_key_exists($value, $this->types)) {
                        $fail('Le type sélectionné est invalide.');
                    }
                }
            ],
            'description' => 'nullable|string',
            'photo' => 'required|image|max:2048',
            'ville' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'heure_debut' => 'required|string',
            'heure_fin' => 'required|string',
            'type_autre' => 'required_if:event_type_id,' . $this->autreTypeId . '|nullable|string|max:255',
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
            ->post(env('API_URL') . '/events', $data);

        if ($response->successful()) {
            session()->flash('success', $response->json()['message']);
            $this->dispatch('show-success', message: $response->json()['message']);
            $this->redirect(route('events.show', $response->json()['event']['id']));
        } else {
            $errors = $response->json()['message'] ?? 'Erreur lors de la création de l\'événement.';
            session()->flash('error', $errors);
            $this->dispatch('show-error', message: $errors);
        }
    }

    public function render()
    {
        return view('livewire.event.create');
    }
}
