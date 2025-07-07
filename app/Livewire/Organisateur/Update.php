<?php

namespace App\Livewire\Organisateur;

use App\Models\Organizer;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class Update extends Component
{

    public User $user;

    public $username = '';
    public $email = '';
    public $telephone = [];

    public function rules()
    {
        return [
            'username' => 'required|string',
            'email' => 'required|string',
            'telephone' => 'required|string',

        ];
    }

    public function mount()
    {
        // $this->levels = Level::all();
    }

    #[On('organisateurToEdit')]
    public function organisateurToEdit($id)
    {
        $this->user = User::query()->findOrFail($id);
        $this->username = $this->user->username;
        $this->email = $this->user->email;
        $this->telephone = $this->user->telephone;
        $this->dispatch('update-event');
    }


    public function update()
    {
        $this->validate();
        $this->user->username = $this->username;
        $this->user->email = $this->email;
        $this->user->telephone = $this->telephone;
        $this->user->update();

        redirect()->route('organisateurs')->with('message', 'Organisateur ' . $this->username . ' modifié avec succès');
    }
    public function render()
    {
        return view('livewire.organisateur.update');
    }
}
