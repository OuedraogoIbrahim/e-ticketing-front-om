<div class="container">
    <div class="card">
        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
            <h5 class="form-title-orange mb-0">Détails de l'événement</h5>
            <a href="{{ route('events.index') }}" class="btn btn-warning">
                <i class="ti ti-arrow-left me-1 ti-xs"></i> Retour à la liste
            </a>
        </div>
        <div class="card-body p-6">
            @if (session()->has('message'))
                <div class="alert alert-info mb-4">
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if ($event)
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <h6 class="fw-bold">Titre</h6>
                        <p>{{ $event['titre'] }}</p>
                    </div>
                    <div class="col-md-6 mb-4">
                        <h6 class="fw-bold">Ville</h6>
                        <p>{{ $event['ville'] }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <h6 class="fw-bold">Prix (Francs)</h6>
                        <p>{{ number_format($event['prix'], 0, '.', '.') }}</p>
                    </div>
                    <div class="col-md-6 mb-4">
                        <h6 class="fw-bold">Photo</h6>
                        @if ($event['photo'])
                            <img src="{{ $event['photo'] }}" alt="Photo de l'événement" class="img-thumbnail"
                                style="max-width: 200px;">
                        @else
                            <p>Aucune photo pour cet événement</p>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <h6 class="fw-bold">Date de début</h6>
                        <p>{{ $event['date_debut'] }}</p>
                    </div>
                    <div class="col-md-6 mb-4">
                        <h6 class="fw-bold">Date de fin</h6>
                        <p>{{ $event['date_fin'] ?? 'Non spécifiée' }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <h6 class="fw-bold">Heure de début</h6>
                        <p>{{ $event['heure_debut'] }}</p>
                    </div>
                    <div class="col-md-6 mb-4">
                        <h6 class="fw-bold">Heure de fin</h6>
                        <p>{{ $event['heure_fin'] ?? 'Non spécifiée' }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <h6 class="fw-bold">Nombre de tickets</h6>
                        <p>{{ $event['nombre_tickets'] }}</p>
                    </div>

                    <div class="col-md-6 mb-4">
                        <h6 class="fw-bold">Ticket(s) restants(s)</h6>
                        <p>{{ $event['tickets_disponibles'] ?? 'Inconnu' }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <h6 class="fw-bold">Type</h6>
                        <p>{{ $event['type']['nom'] ?? 'Inconnu' }}</p>
                    </div>
                    <div class="col-md-12 mb-4">
                        <h6 class="fw-bold">Description</h6>
                        <p>{{ $event['description'] ?? 'Aucune description disponible' }}</p>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('events.edit', $event['id']) }}" class="btn btn-warning">
                        <i class="ti ti-edit me-1 ti-xs"></i> Modifier
                    </a>
                </div>
            @else
                <div class="alert alert-danger text-center">
                    Événement non trouvé.
                </div>
            @endif
        </div>
    </div>
</div>

@script
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('show-error', (event) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: event.message,
                    showConfirmButton: true
                });
            });
        });
    </script>
@endscript
