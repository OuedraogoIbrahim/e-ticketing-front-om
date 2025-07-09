@php
    use Carbon\Carbon;
@endphp
<div class="row g-6">

    <div class="m-5">
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Statistiques des tickets -->
    <div class="col-lg-4 col-sm-6">
        <div class="card card-border-shadow-primary h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-primary"><i class='ti ti-ticket ti-28px'></i></span>
                    </div>
                    <h4 class="mb-0">{{ $stats['tickets_total'] }}</h4>
                </div>
                <p class="mb-1">Tickets achetés</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-6">
        <div class="card card-border-shadow-warning h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-warning"><i class='ti ti-clock ti-28px'></i></span>
                    </div>
                    <h4 class="mb-0">{{ $stats['tickets_non_utilises'] }}</h4>
                </div>
                <p class="mb-1">Tickets non utilisés</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-6">
        <div class="card card-border-shadow-danger h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded bg-label-danger"><i
                                class='ti ti-arrows-exchange ti-28px'></i></span>
                    </div>
                    <h4 class="mb-0">{{ $stats['tickets_transferes'] }}</h4>
                </div>
                <p class="mb-1">Tickets transférés</p>
            </div>
        </div>
    </div>
    <!--/ Statistiques des tickets -->

    <!-- Événements à venir -->
    <div class="col-12">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="card-title mb-0">
                    <h5 class="mb-1">Événements à venir</h5>
                    <p class="card-subtitle">Vos événements à venir</p>
                </div>
            </div>
            <div class="card-body">
                @if (count($events) > 0)
                    <div class="row g-4">
                        @foreach ($events as $event)
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="card card-border-shadow-primary h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start mb-3">
                                            <div class="avatar flex-shrink-0 me-3">
                                                <span class="avatar-initial rounded bg-label-warning">
                                                    <i class="ti ti-calendar-event ti-24px"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-normal">{{ $event['titre'] }}</h6>
                                                <small class="text-muted d-block mb-1">
                                                    {{ $event['date_debut'] }} - {{ $event['ville'] }}
                                                </small>
                                                <span class="fw-bold fs-5">
                                                    {{ count($event['tickets']) }}
                                                    ticket{{ count($event['tickets']) > 1 ? 's' : '' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('list.events.show', $event['id']) }}"
                                                class="btn btn-sm btn-outline-dark" data-bs-toggle="tooltip"
                                                title="Voir l'événement">
                                                <i class="ti ti-eye ti-20px"></i>
                                            </a>
                                            <button wire:click="openTransferModal({{ $event['tickets'][0]['id'] }})"
                                                class="btn btn-sm btn-outline-dark" data-bs-toggle="modal"
                                                data-bs-target="#transferTicketModal" data-bs-toggle="tooltip"
                                                title="Transférer le ticket">
                                                <i class="ti ti-arrows-exchange ti-20px"></i>
                                            </button>
                                            <button wire:loading.attr="disabled"
                                                wire:click="downloadTicket({{ $event['id'] }})"
                                                class="btn btn-sm btn-outline-dark" data-bs-toggle="tooltip"
                                                title="Télécharger le(s) QR code(s)">
                                                <i class="ti ti-download ti-20px"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        @if ($links)
                            @foreach ($links as $link)
                                @if ($link['url'])
                                    <a href="{{ $link['url'] }}"
                                        class="btn btn-sm {{ $link['active'] ? 'btn-primary' : 'btn-outline-primary' }}">
                                        {!! $link['label'] !!}
                                    </a>
                                @else
                                    <span class="btn btn-sm btn-outline-primary disabled">{!! $link['label'] !!}</span>
                                @endif
                            @endforeach
                        @endif
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="ti ti-calendar-off ti-48px text-muted mb-3"></i>
                        <p class="text-muted">Aucun ticket pour des événements à venir</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!--/ Événements à venir -->

    {{-- Modal pour le transfert de ticket --}}
    @include('_partials._modals.modal-transfert-ticket')

    <div wire:loading.flex
        class="position-fixed top-0 start-0 w-100 h-100 justify-content-center align-items-center z-3 bg-light bg-opacity-50">
        <div class="d-flex flex-column align-items-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Chargement...</span>
            </div>
            <p class="mt-2 text-primary">Chargement en cours...</p>
        </div>
    </div>
</div>

@script
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('show-success', (event) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Succès',
                    text: event.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            });

            Livewire.on('show-error', (event) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: event.message,
                    showConfirmButton: true
                });
            });

            Livewire.on('close-modal', () => {
                const modal = document.getElementById('transferTicketModal');
                const bootstrapModal = bootstrap.Modal.getInstance(modal);
                if (bootstrapModal) {
                    bootstrapModal.hide();
                }
            });
        });
    </script>
@endscript
