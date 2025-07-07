<div>
    <div class="card">
        <div class="m-5">
            @if (session()->has('message'))
                <div class="alert alert-info">
                    {{ session('message') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
        </div>

        <div class="card-header border-bottom">
            <h5 class="card-title mb-0">Filtres</h5>
            <div class="d-flex justify-content-between align-items-center row pt-4 gap-4 gap-md-0">
                <div class="col-md-3 mb-4">
                    <label>Type</label>
                    <select class="form-select" name="type" wire:model.live.debounce.500ms="searchType" id="">
                        @foreach ($types as $t)
                            <option value="{{ $t->id }}">{{ $t->nom }}</option>
                        @endforeach
                    </select>

                </div>
                <div class="col-md-3 mb-4">
                    <label>Ville</label>
                    <input type="search" wire:model.live.debounce.500ms='searchVille' class="form-control"
                        placeholder="Rechercher par ville...">
                </div>
                <div class="col-md-3 mb-4">
                    <label>Prix minimum (Francs)</label>
                    <input type="number" wire:model.live.debounce.500ms='searchPrixMin' class="form-control"
                        placeholder="Prix min">
                </div>
                <div class="col-md-3 mb-4">
                    <label>Date de début</label>
                    <input type="date" wire:model.live.debounce.500ms='searchDateDebut' class="form-control">
                </div>
            </div>
        </div>

        <div class="row m-5">
            <div class="col-md-12">
                <div
                    class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-6 mb-md-0 mt-n6 mt-md-0">
                    <div class="dt-buttons btn-group flex-wrap">
                        <a href="{{ route('events.create') }}"
                            class="btn add-new btn-warning waves-effect waves-light mb-4" tabindex="0"
                            aria-controls="DataTables_Table_0" type="button">
                            <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                    class="d-none d-sm-inline-block">Ajouter un événement</span></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-datatable table-responsive">
            <table class="datatables-users table">
                <thead class="border-top">
                    <tr>
                        <th>Titre</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Prix</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($events->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center text-muted">Aucun événement trouvé.</td>
                        </tr>
                    @else
                        @foreach ($events as $event)
                            <tr>
                                <th>{{ $event->titre }}</th>
                                <th>{{ $event->type->nom }}</th>
                                <th>{{ $event->date_debut }} à {{ $event->date_fin }}</th>
                                <th>{{ $event->heure_debut }} - {{ $event->heure_fin }}</th>
                                <th>{{ number_format($event->prix, 0, ',', ' ') }} Francs</th>
                                <td class="d-flex align-items-center">
                                    <a href="{{ route('events.edit', $event->id) }}"
                                        class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <a href="{{ route('events.show', $event->id) }}"
                                        class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    <a href="{{ route('events.history', $event->id) }}"
                                        class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect">
                                        <i class="ti ti-history"></i>
                                    </a>
                                    <a href="javascript:void(0);" onclick="confirmDelete(event, '{{ $event->id }}')"
                                        class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill delete-record">
                                        <i class="ti ti-trash ti-md"></i>
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            <div class="my-4">
                {{ $events->links('pagination::bootstrap-5') }}
            </div>
        </div>

        <script>
            function confirmDelete(event, eventId) {
                event.preventDefault();

                Swal.fire({
                    title: 'Êtes-vous sûr ?',
                    text: 'Vous ne pourrez pas revenir en arrière !',
                    imageUrl: "{{ asset('assets/lordicon/delete.gif') }}",
                    // icon: 'warning',
                    imageWidth: 100, // Largeur du GIF
                    imageHeight: 100, // Hauteur du GIF
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Oui, supprimer !',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            icon: "success",
                            title: 'Evenement supprimée avec succès.',
                            showConfirmButton: false,
                            timer: 1000
                        });
                        @this.call('deleteEvent', eventId); // Appelez la méthode Livewire pour supprimer
                    }
                });
            }
        </script>
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
