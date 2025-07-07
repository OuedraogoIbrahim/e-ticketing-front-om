<?php

namespace App\Livewire\Dashboard;

use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Ticket;
use App\Models\TicketTransfer;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Client extends Component
{
    use WithPagination;

    public $ticketsCount;
    public $ticket;
    public $phone = '';
    public $quantity = 1;

    public function mount()
    {
        $this->ticketsCount = Auth::user()->client->tickets()->with('event')->get();
        $this->ticket = null;
    }

    public function openTransferModal($ticketId)
    {
        $this->ticket = Auth::user()->client->tickets()->with('event')->findOrFail($ticketId);
        $this->phone = '';
        $this->quantity = 1;
    }

    public function transferTicket($ticketId, $phone, $quantity)
    {
        // Compter les tickets disponibles pour l'événement
        $totalTickets = Auth::user()->client->tickets()
            ->where('event_id', $this->ticket->event_id)
            ->whereNull('date_utilisation')
            ->count();

        $this->validate([
            'phone' => 'required|regex:/^\+?[1-9]\d{1,14}$/',
            'quantity' => 'required|integer|min:1|max:' . $totalTickets,
        ]);

        // Trouver le ticket original
        $ticket = Auth::user()->client->tickets()->with('event')->findOrFail($ticketId);

        // Vérifier le destinataire par numéro de téléphone
        $destinataire = User::query()->where('telephone', $phone)->first();
        if (!$destinataire) {
            $this->addError('phone', 'Aucun client trouvé avec ce numéro de téléphone.');
            return;
        }

        // Vérifier la quantité disponible pour l'événement
        if ($quantity > $totalTickets) {
            $this->addError('quantity', 'Quantité insuffisante pour cet événement.');
            return;
        }

        // Transférer les tickets (changer client_id pour $quantity lignes)
        $ticketsToTransfer = Auth::user()->client->tickets()
            ->where('event_id', $ticket->event_id)
            ->whereNull('date_utilisation')
            ->take($quantity)
            ->get();

        foreach ($ticketsToTransfer as $ticketToTransfer) {
            $ticketToTransfer->update([
                'client_id' => $destinataire->client->id,
                'date_achat' => $ticket->date_achat,
                'token' => Str::uuid(), // Générer un nouveau token pour le ticket transféré
            ]);
        }

        // Enregistrer le transfert
        TicketTransfer::create([
            'event_id' => $ticket->event_id,
            'from_client_id' => Auth::user()->client->id,
            'to_client_id' => $destinataire->client->id,
            'quantity' => $quantity,
            'transferred_at' => now(),
        ]);

        // Mettre à jour ticketsCount
        $this->ticketsCount = Auth::user()->client->tickets()->with('event')->get();

        session()->flash('message', 'Ticket transféré avec succès.');
        $this->dispatch('close-modal');
    }

    public function downloadTicket($eventId)
    {
        $tickets = Auth::user()->client->tickets()
            ->with('event')
            ->where('event_id', $eventId)
            ->whereNull('date_utilisation')
            ->get();

        if ($tickets->isEmpty()) {
            session()->flash('error', 'Aucun ticket disponible pour cet événement.');
            return;
        }

        $pdf = Pdf::loadView('pdf.ticket', [
            'tickets' => $tickets,
            'event' => $tickets[0]->event,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'ticket-event-' . $eventId . '.pdf');
    }

    public function render()
    {

        $client = Auth::user()->client;

        $events = Event::whereHas('tickets', function ($q) use ($client) {
            $q->where('client_id', $client->id)
                ->whereNull('date_utilisation');
        })
            ->where('date_debut', '>', Carbon::today())
            ->with(['tickets' => fn($q) => $q->where('client_id', $client->id)->whereNull('date_utilisation')])
            ->paginate(6);

        return view('livewire.dashboard.client', compact('events'));
    }
}
