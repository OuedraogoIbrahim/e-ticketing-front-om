@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutFront')

@section('title', $event->titre)

<!-- Vendor Styles -->
@section('vendor-style')
@endsection

<!-- Page Styles -->
@section('page-style')
    <style>
        .event-header {
            padding-top: 100px;
            /* Compensation pour la navbar fixe */
            padding-bottom: 2rem;
            margin-bottom: 2rem;
            border-bottom: 1px solid #dee2e6;
        }

        .event-img {
            max-height: 400px;
            object-fit: cover;
            width: 100%;
            border-radius: 0.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .btn-back {
            background-color: #6c757d;
            color: white;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background-color: #5a6268;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .type-badge {
            font-size: 0.9rem;
            padding: 0.35rem 0.75rem;
            background-color: #6c757d;
            color: white;
            border-radius: 50rem;
        }
    </style>
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
@endsection

<!-- Page Scripts -->
@section('page-script')
@endsection

@section('content')
    <!-- En-tête de l'événement -->
    <div class="event-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <span class="type-badge mb-2 d-inline-block">{{ $event->type->nom }}</span>
                    <h3 class="fw-bold text-dark mb-3">{{ $event->titre }}</h3>
                    <div class="d-flex align-items-center mb-3 p-3 rounded-3">
                        <span class="badge bg-success me-2 p-2">
                            <i class="fas fa-ticket-alt"></i>
                        </span>
                        <div class="fs-4">
                            <span
                                class="fw-bold">{{ $event->nombre_tickets - App\Models\Ticket::where('event_id', $event->id)->count() }}
                            </span>
                            <span class="ms-1">tickets disponibles</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    @if ($event->nombre_tickets > 0)
                        <a href="{{ route('tickets.purchase', $event->id) }}"
                            class="btn btn-outline-success btn-lg px-4 py-2 me-2">
                            <i class="fas fa-ticket-alt me-2"></i>Acheter des tickets
                        </a>
                    @else
                        <button class="btn btn-secondary btn-lg px-4 py-2 me-2" disabled>
                            <i class="fas fa-times-circle me-2"></i>Complet
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="container my-5">
        <div class="row">
            <!-- Image de l'événement -->
            <div class="col-lg-6 mb-4">
                @if ($event->photo)
                    <img src="{{ asset('storage/' . $event->photo) }}" alt="{{ $event->titre }}" class="event-img">
                @else
                    <img src="{{ asset('assets/img/placeholder-event.jpg') }}" alt="Default Event" class="event-img">
                @endif
            </div>

            <!-- Accordéons pour les détails -->
            <div class="col-lg-6">
                <div class="accordion" id="eventAccordion">
                    <!-- Description -->
                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header" id="headingDescription">
                            <button class="accordion-button py-3" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseDescription" aria-expanded="true"
                                aria-controls="collapseDescription">
                                <i class="fas fa-info-circle me-2 text-primary"></i> Description
                            </button>
                        </h2>
                        <div id="collapseDescription" class="accordion-collapse collapse show"
                            aria-labelledby="headingDescription" data-bs-parent="#eventAccordion">
                            <div class="accordion-body">
                                {{ $event->description ?? 'Aucune description disponible.' }}
                            </div>
                        </div>
                    </div>

                    <!-- Détails de l'événement -->
                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header" id="headingDetails">
                            <button class="accordion-button collapsed py-3" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseDetails" aria-expanded="false" aria-controls="collapseDetails">
                                <i class="fas fa-calendar-day me-2 text-primary"></i> Détails de l'événement
                            </button>
                        </h2>
                        <div id="collapseDetails" class="accordion-collapse collapse" aria-labelledby="headingDetails"
                            data-bs-parent="#eventAccordion">
                            <div class="accordion-body">
                                <div class="d-flex mb-2">
                                    <i class="fas fa-calendar-alt text-muted me-3 mt-1"></i>
                                    <div>
                                        <strong>Date :</strong>
                                        {{ \Carbon\Carbon::parse($event->date_debut)->translatedFormat('j F Y') }}
                                        @if ($event->date_fin && $event->date_fin != $event->date_debut)
                                            au {{ \Carbon\Carbon::parse($event->date_fin)->translatedFormat('j F Y') }}
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex mb-2">
                                    <i class="fas fa-clock text-muted me-3 mt-1"></i>
                                    <div>
                                        <strong>Horaire :</strong> {{ $event->heure_debut }} - {{ $event->heure_fin }}
                                    </div>
                                </div>
                                <div class="d-flex mb-2">
                                    <i class="fas fa-tag text-muted me-3 mt-1"></i>
                                    <div>
                                        <strong>Prix :</strong> {{ number_format($event->prix, 0, '.', '.') }} Francs
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <i class="fas fa-ticket-alt text-muted me-3 mt-1"></i>
                                    <div>
                                        <strong>Places disponibles :</strong> {{ $event->nombre_tickets }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Localisation -->
                    <div class="accordion-item border-0 mb-3 shadow-sm">
                        <h2 class="accordion-header" id="headingLocation">
                            <button class="accordion-button collapsed py-3" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseLocation" aria-expanded="false" aria-controls="collapseLocation">
                                <i class="fas fa-map-marked-alt me-2 text-primary"></i> Localisation
                            </button>
                        </h2>
                        <div id="collapseLocation" class="accordion-collapse collapse" aria-labelledby="headingLocation"
                            data-bs-parent="#eventAccordion">
                            <div class="accordion-body">
                                <div class="d-flex">
                                    <i class="fas fa-city text-muted me-3 mt-1"></i>
                                    <div>
                                        <strong>Ville :</strong> {{ $event->ville }}
                                    </div>
                                </div>
                                <!-- Vous pourriez ajouter une carte ici plus tard -->
                            </div>
                        </div>
                    </div>

                    <!-- Organisateur -->
                    <div class="accordion-item border-0 shadow-sm">
                        <h2 class="accordion-header" id="headingOrganizer">
                            <button class="accordion-button collapsed py-3" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOrganizer" aria-expanded="false" aria-controls="collapseOrganizer">
                                <i class="fas fa-user-tie me-2 text-primary"></i> Organisateur
                            </button>
                        </h2>
                        <div id="collapseOrganizer" class="accordion-collapse collapse" aria-labelledby="headingOrganizer"
                            data-bs-parent="#eventAccordion">
                            <div class="accordion-body">
                                <div class="d-flex">
                                    <i class="fas fa-user text-muted me-3 mt-1"></i>
                                    <div>
                                        <strong>Nom :</strong> {{ $event->organizer->user->username ?? 'Non spécifié' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bouton Retour -->
                <div class="mt-4 text-center text-lg-start">
                    <a href="{{ route('list.events.index') }}" class="btn btn-back btn-lg px-4 py-2">
                        <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
