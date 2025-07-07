<?php

namespace App\Livewire\Organisateur;

use App\Models\Organizer;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;

    public $search;

    public function deleteOrganisateur($id)
    {
        $user = User::query()->findOrFail($id);
        $user->delete();
    }

    public function sendOrganisateur($id)
    {
        $this->dispatch('organisateurToEdit', id: $id)->to(Update::class);
    }
    public function render()
    {
        $organisateurs = User::query()
            ->where('role', 'organisateur')
            // Ajouter une condition pour filtrer par nom ou prénom
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('username', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate(10);

        return view('livewire.organisateur.index', compact('organisateurs'));
    }
}
