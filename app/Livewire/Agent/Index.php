<?php

namespace App\Livewire\Agent;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Index extends Component
{
    public $allAgents = [];
    public $nom = '';
    public $password = '';
    public $agentId = null; // Pour la modification

    public function mount()
    {
        $this->fetchAgents();
    }

    public function fetchAgents()
    {
        $response = Http::withToken(session(env('API_TOKEN_NAME')))->get(env('API_URL') . '/agents');
        if ($response->successful()) {
            $this->allAgents = $response->json();
        } else {
            session()->flash('error', 'Erreur lors de la récupération des agents.');
            $this->dispatch('show-error', message: 'Erreur lors de la récupération des agents.');
        }
    }

    public function createAgent()
    {
        $validated = $this->validate([
            'nom' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        $response = Http::withToken(session(env('API_TOKEN_NAME')))
            ->post(env('API_URL') . '/agents', $validated);

        if ($response->successful()) {
            session()->flash('message', $response->json()['message']);
            $this->dispatch('show-success', message: $response->json()['message']);
            $this->reset(['nom', 'password']);
            $this->fetchAgents(); // Rafraîchir la liste
            $this->dispatch('close-modal', id: 'addAgentModal');
        } else {
            $errors = $response->json()['message'] ?? 'Erreur lors de la création de l\'agent.';
            session()->flash('error', $errors);
            $this->dispatch('show-error', message: $errors);
        }
    }

    public function editAgent($id)
    {
        $this->agentId = $id;
        $response = Http::withToken(session(env('API_TOKEN_NAME')))->get(env('API_URL') . '/agents/' . $id);
        if ($response->successful()) {
            $agent = $response->json();
            $this->nom = $agent['nom'];
            $this->password = ''; // Mot de passe non récupéré pour sécurité
            $this->dispatch('open-modal', id: 'editAgentModal');
        } else {
            session()->flash('error', $response->json()['message'] ?? 'Erreur lors de la récupération de l\'agent.');
            $this->dispatch('show-error', message: $response->json()['message'] ?? 'Erreur lors de la récupération de l\'agent.');
        }
    }

    public function updateAgent()
    {
        $validated = $this->validate([
            'nom' => 'required|string|max:255',
            'password' => 'nullable|string|min:8',
        ]);

        $data = ['nom' => $validated['nom']];
        if (!empty($validated['password'])) {
            $data['password'] = $validated['password'];
        }

        $response = Http::withToken(session(env('API_TOKEN_NAME')))
            ->put(env('API_URL') . '/agents/' . $this->agentId, $data);

        if ($response->successful()) {
            session()->flash('message', $response->json()['message']);
            $this->dispatch('show-success', message: $response->json()['message']);
            $this->reset(['nom', 'password', 'agentId']);
            $this->fetchAgents();
            $this->dispatch('close-edit-modal');
        } else {
            $errors = $response->json()['message'] ?? 'Erreur lors de la mise à jour de l\'agent.';
            session()->flash('error', $errors);
            $this->dispatch('show-error', message: $errors);
        }
    }

    public function deleteAgent($id)
    {
        $response = Http::withToken(session(env('API_TOKEN_NAME')))->delete(env('API_URL') . '/agents/' . $id);
        if ($response->successful()) {
            // $this->allAgents = array_filter($this->allAgents, fn($agent) => $agent['id'] !== $id);
            $this->fetchAgents();
            session()->flash('message', $response->json()['message']);
            $this->dispatch('show-success', message: $response->json()['message']);
        } else {
            session()->flash('error', $response->json()['message'] ?? 'Erreur lors de la suppression de l\'agent.');
            $this->dispatch('show-error', message: $response->json()['message'] ?? 'Erreur lors de la suppression de l\'agent.');
        }
    }

    public function render()
    {
        return view('livewire.agent.index', [
            'agents' => $this->allAgents,
        ]);
    }
}
