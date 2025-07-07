<div>
    <div class="container">
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Statistiques des tickets - {{ $event->titre }}</h5>
                <a href="{{ route('events.index') }}" class="btn btn-warning">
                    <i class="ti ti-arrow-left me-1 ti-xs"></i> Retour aux évènements
                </a>
            </div>
            <div class="card-body p-6">
                @if (session()->has('message'))
                    <div class="alert alert-info mb-4">
                        {{ session('message') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Affichage de l'état de l'événement -->
                <div class="mb-4">
                    <h6 class="fw-bold">État de l'événement</h6>
                    <span class="badge {{ $eventStatus['class'] }}">{{ $eventStatus['text'] }}</span>
                </div>

                <!-- Statistiques des tickets -->
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h6 class="card-title">Tickets vendus</h6>
                                <p class="display-6 mb-0">{{ $stats['totalTickets'] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h6 class="card-title">Tickets transférés</h6>
                                <p class="display-6 mb-0">{{ $stats['transferredTickets'] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h6 class="card-title">Tickets utilisés</h6>
                                <p class="display-6 mb-0">{{ $stats['usedTickets'] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h6 class="card-title">Tickets restants</h6>
                                <p class="display-6 mb-0">{{ $stats['remainingTickets'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div wire:loading.class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center">
        <div wire:loading class="sk-chase sk-primary">
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
            <div class="sk-chase-dot"></div>
        </div>
    </div>
</div>
