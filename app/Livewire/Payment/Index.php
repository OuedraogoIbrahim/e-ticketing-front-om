<?php

namespace App\Livewire\Payment;

use Illuminate\Support\Str;
use App\Models\Event;
use App\Models\Payment;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public Event $event;
    public $nombre_tickets = 1;
    public $telephone;

    protected $rules = [
        'nombre_tickets' => 'required|numeric|min:1',
        'telephone' => 'required'
    ];

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function purchase()
    {
        $this->validate();

        // Ici la logique de paiement Orange Money

        //Fin logique paiement


        for ($i = 1; $i <= $this->nombre_tickets; $i++) {
            Ticket::create([
                'client_id' => Auth::user()->client->id,
                'event_id' => $this->event->id,
                'date_achat' => now(),
                'token' => Str::random(32),
            ]);
        }

        Payment::create([
            'user_id' => Auth::id(),
            'event_id' => $this->event->id,
            'montant_total' => $this->event->prix * $this->nombre_tickets,
            'quantite_ticket' => $this->nombre_tickets,
            'numero_orange_money' => $this->telephone
        ]);

        return redirect()->route('dashboard')->with('success-payment', 'Ticket(s) payé(s) avec succès ');
    }

    public function render()
    {
        return view('livewire.payment.index');
    }
}
