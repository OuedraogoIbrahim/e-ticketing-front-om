<?php

namespace App\Livewire\Organisateur;

use App\Models\Organizer;
use App\Models\User;
use Livewire\Component;

class Create extends Component
{

    public $username = '';
    public $email = '';
    public $telephone = '';

    protected $rules = [
        'username' => 'required|min:3|max:50',
        'email' => 'required|email|unique:users,email',
        'telephone' => 'required',
    ];

    public function mount()
    {
        // $this->levels = Level::all();
    }

    public function submit()
    {
        $this->validate();
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->telephone = $this->telephone;
        $user->role = "organisateur";
        $user->password = "password";
        $user->save();

        $organisateur = new Organizer();
        $organisateur->user_id = $user->id;
        $organisateur->save();

        return redirect()->route('organisateurs.index')->with('message', 'Organisateur ' . $this->username . ' ajouté avec succès');
    }
    public function render()
    {
        return view('livewire.organisateur.create');
    }
}
