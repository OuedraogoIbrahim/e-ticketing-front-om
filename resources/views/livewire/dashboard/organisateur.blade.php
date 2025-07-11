<div class="row g-4">
    <!-- Cartes de stats globales -->
    <div class="col-md-6">
        <div class="card card-border-shadow-primary h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar me-3">
                        <span class="avatar-initial rounded bg-label-primary">
                            <i class="ti ti-calendar-stats ti-24px"></i>
                        </span>
                    </div>
                    <h4 class="mb-0">{{ $globalStats['total_events'] ?? 0 }}</h4>
                </div>
                <p class="mb-0">Événements créés (total)</p>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-border-shadow-info h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar me-3">
                        <span class="avatar-initial rounded bg-label-info">
                            <i class="ti ti-ticket ti-24px"></i>
                        </span>
                    </div>
                    <h4 class="mb-0">{{ $globalStats['total_tickets'] ?? 0 }}</h4>
                </div>
                <p class="mb-0">Tickets achetés (total)</p>
            </div>
        </div>
    </div>

    <!-- Stats du jour -->
    <div class="col-md-4">
        <div class="card card-border-shadow-warning h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar me-3">
                        <span class="avatar-initial rounded bg-label-warning">
                            <i class="ti ti-sun ti-24px"></i>
                        </span>
                    </div>
                    <h4 class="mb-0">{{ $todayStats['events_count'] ?? 0 }}</h4>
                </div>
                <p class="mb-0">Événements aujourd'hui</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-border-shadow-success h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar me-3">
                        <span class="avatar-initial rounded bg-label-success">
                            <i class="ti ti-check ti-24px"></i>
                        </span>
                    </div>
                    <h4 class="mb-0">{{ $todayStats['tickets_used'] ?? 0 }}</h4>
                </div>
                <p class="mb-0">Tickets utilisés</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-border-shadow-danger h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar me-3">
                        <span class="avatar-initial rounded bg-label-danger">
                            <i class="ti ti-clock ti-24px"></i>
                        </span>
                    </div>
                    <h4 class="mb-0">{{ $todayStats['tickets_unused'] ?? 0 }}</h4>
                </div>
                <p class="mb-0">Tickets non utilisés</p>
            </div>
        </div>
    </div>

    <!-- Liste des événements du jour -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Événements du jour</h5>
            </div>
            <div class="card-body">
                @if (!empty($todayEvents) && count($todayEvents))
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Événement</th>
                                    <th>Heure</th>
                                    <th>Capacité</th>
                                    <th>Achetés</th>
                                    <th>Utilisés</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($todayEvents as $event)
                                    <tr>
                                        <td>{{ $event['titre'] }}</td>
                                        <td>{{ $event['heure_debut'] }}</td>
                                        <td>{{ $event['nombre_ticket'] }}</td>
                                        <td>{{ $event['tickets_achetes'] }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $event['tickets_utilises'] > 0 ? 'success' : 'secondary' }}">
                                                {{ $event['tickets_utilises'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('events.show', $event['id']) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="ti ti-calendar-off ti-48px text-muted"></i>
                        <p class="text-muted mt-2">Aucun événement aujourd'hui</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
