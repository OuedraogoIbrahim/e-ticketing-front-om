@php
    use Carbon\Carbon;
    use Illuminate\Support\Str;
@endphp
<div data-bs-spy="scroll" class="scrollspy-example">
    <!-- Hero: Start -->
    <section id="hero-animation">
        <div class="section-py position-relative container px-5">
            <!-- Header with title -->
            <div class="row mb-5 mx-0">
                <div class="col-12 px-0">
                    <h3 class="mb-3 text-black text-center">Découvrez nos événements</h3>
                </div>
            </div>

            <div class="row mx-0">
                <!-- Filters column -->
                <div class="col-lg-3 mb-4 px-0 pe-lg-3">
                    <h5 class="mb-4">Filtrer les événements</h5>

                    <!-- Search -->
                    {{-- <div class="mb-4">
                        <label class="form-label">Recherche</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent"><i class="ti ti-search"></i></span>
                            <input type="text" wire:model="search" class="form-control border-start-0"
                                placeholder="Mot-clé...">
                        </div>
                    </div> --}}

                    <!-- Type filter -->
                    <div class="mb-4" wire:ignore>
                        <label class="form-label">Type d'événement</label>
                        <select id="type" wire:model="type" class="select2 form-select">
                            <option value="">Tous les types</option>
                            @foreach ($eventTypes as $id => $nom)
                                <option value="{{ $id }}">{{ $nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- City filter -->
                    <div class="mb-4" wire:ignore>
                        <label class="form-label">Ville</label>
                        <select id="ville" wire:model="ville" class="select2 form-select">
                            <option value="">Toutes les villes</option>
                            @foreach ($villes as $ville)
                                <option value="{{ $ville }}">{{ $ville }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date filter -->
                    <div class="mb-4" wire:ignore>
                        <label class="form-label">Date</label>
                        <select id="date" wire:model="date" class="select2 form-select">
                            <option value="">Toutes les dates</option>
                            <option value="today">Aujourd'hui</option>
                            <option value="week">Cette semaine</option>
                            <option value="month">Ce mois</option>
                        </select>
                    </div>

                    <!-- Bouton Rechercher -->
                    {{-- <button wire:click="search" class="btn btn-primary w-100 mb-3">
                        <i class="ti ti-search me-2"></i>Rechercher
                    </button> --}}

                    <!-- Reset button -->
                    <button type="button" wire:click="resetFilters" class="btn btn-outline-secondary w-100">
                        <i class="ti ti-x me-2"></i>Réinitialiser
                    </button>
                </div>

                <!-- Events list column -->
                <div class="col-lg-9 px-0 ps-lg-3">
                    @forelse ($events as $event)
                        <div class="card mb-4 shadow-sm border-0">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <div class="ratio ratio-16x9 h-100">
                                        <img src="{{ $event['photo'] ? $event['photo'] : asset('assets/img/placeholder-event.jpg') }}"
                                            class="img-fluid rounded-start object-fit-cover"
                                            alt="{{ $event['titre'] }}">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h5 class="card-title mb-1">{{ $event['titre'] }}</h5>
                                                <span
                                                    class="badge bg-primary mb-2">{{ $event['type']['nom'] ?? 'Inconnu' }}</span>
                                            </div>
                                            <div class="text-end">
                                                <span
                                                    class="fw-bold fs-5">{{ number_format($event['prix'], 0, ',', ' ') }}
                                                    FCFA</span>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center text-muted mb-2">
                                            <i class="ti ti-calendar me-2"></i>
                                            <span>{{ Carbon::parse($event['date_debut'])->format('d/m/Y') }} •
                                                {{ $event['heure_debut'] }}</span>
                                        </div>

                                        <div class="d-flex align-items-center text-muted mb-3">
                                            <i class="ti ti-map-pin me-2"></i>
                                            <span>{{ $event['ville'] }}</span>
                                        </div>

                                        <p class="card-text text-truncate mb-3">
                                            {{ Str::limit($event['description'], 120) }}</p>

                                        <a href="{{ route('list.events.show', $event['id']) }}"
                                            class="btn btn-outline-dark">
                                            Voir détails
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="card shadow-sm border-0">
                            <div class="card-body text-center py-5">
                                <i class="ti ti-calendar-off fs-1 text-muted mb-3"></i>
                                <h5 class="text-muted">Aucun événement trouvé</h5>
                                <p class="text-muted">Essayez de modifier vos critères de recherche</p>
                            </div>
                        </div>
                    @endforelse

                    <!-- Pagination -->
                    @if ($pagination)
                        <div class="mt-4">
                            @if ($pagination['current_page'] > 1)
                                <button wire:click="previousPage" class="btn btn-outline-primary">Précédent</button>
                            @endif

                            @if ($pagination['current_page'] < $pagination['last_page'])
                                <button wire:click="nextPage" class="btn btn-outline-primary">Suivant</button>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- Hero: End -->

    <div
        wire:loading.class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-white bg-opacity-75">
        <div wire:loading class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Chargement...</span>
        </div>
    </div>
</div>

@script
    <script>
        $(document).ready(function() {
            $('#ville, #date, #type').on('change', function(e) {
                let data = $(this).val();
                let model = $(this).attr('id');
                @this.set(model, data);
            });
        });
    </script>
@endscript
