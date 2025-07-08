<div class="container">
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="form-title-orange mb-0">Modifier un événement</h5>
        </div>
        <div class="card-body p-6">
            @if (session()->has('success'))
                <div class="alert alert-success mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if ($event)
                <form class="edit-event-form pt-0" id="editEventForm" wire:submit='submit'>
                    <div class="row">
                        <div class="col-md-6 mb-6">
                            <label class="form-label" for="titre">Titre <span class="text-danger">*</span></label>
                            <input autocomplete="off" type="text" wire:model.defer='titre'
                                class="form-control @error('titre') is-invalid @enderror" id="titre"
                                placeholder="Entrez le titre de l'événement" />
                            @error('titre')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-6">
                            <label class="form-label" for="ville">Ville <span class="text-danger">*</span></label>
                            <input autocomplete="off" type="text" wire:model.defer='ville'
                                class="form-control @error('ville') is-invalid @enderror" id="ville"
                                placeholder="Entrez la ville" />
                            @error('ville')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-6">
                            <label class="form-label" for="prix">Prix (Francs) <span
                                    class="text-danger">*</span></label>
                            <input autocomplete="off" type="number" wire:model.defer='prix'
                                class="form-control @error('prix') is-invalid @enderror" id="prix"
                                placeholder="Entrez le prix" />
                            @error('prix')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-6">
                            <label class="form-label" for="photo">Photo</label>
                            <input type="file" wire:model='photo'
                                class="form-control @error('photo') is-invalid @enderror" id="photo" />
                            @if ($photo || $event['photo'])
                                <div class="mt-2">
                                    <img src="{{ $photo ? $photo->temporaryUrl() : $event['photo'] }}"
                                        alt="Photo de l'événement" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            @endif
                            @error('photo')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-6">
                            <label class="form-label" for="date_debut">Date de début <span
                                    class="text-danger">*</span></label>
                            <input autocomplete="off" type="date" wire:model.defer='date_debut'
                                class="form-control @error('date_debut') is-invalid @enderror" id="date_debut" />
                            @error('date_debut')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-6">
                            <label class="form-label" for="date_fin">Date de fin <span
                                    class="text-danger">*</span></label>
                            <input autocomplete="off" type="date" wire:model.defer='date_fin'
                                class="form-control @error('date_fin') is-invalid @enderror" id="date_fin" />
                            @error('date_fin')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-6">
                            <label class="form-label" for="heure_debut">Heure de début <span
                                    class="text-danger">*</span></label>
                            <input autocomplete="off" type="time" wire:model.defer='heure_debut'
                                class="form-control @error('heure_debut') is-invalid @enderror" id="heure_debut" />
                            @error('heure_debut')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-6">
                            <label class="form-label" for="heure_fin">Heure de fin</label>
                            <input autocomplete="off" type="time" wire:model.defer='heure_fin'
                                class="form-control @error('heure_fin') is-invalid @enderror" id="heure_fin" />
                            @error('heure_fin')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-6">
                            <label class="form-label" for="nombre_tickets">Nombre de tickets <span
                                    class="text-danger">*</span></label>
                            <input autocomplete="off" type="number" wire:model.defer='nombre_tickets'
                                class="form-control @error('nombre_tickets') is-invalid @enderror" id="nombre_tickets"
                                placeholder="Entrez le nombre de tickets" />
                            @error('nombre_tickets')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-6">
                            <label class="form-label" for="event_type_id">Type <span
                                    class="text-danger">*</span></label>
                            <select name="event_type_id" wire:model.defer='event_type_id'
                                class="form-select @error('event_type_id') is-invalid @enderror" id="event_type_id">
                                <option value="">Sélectionner un type</option>
                                @foreach ($types as $id => $nom)
                                    <option value="{{ $id }}">{{ $nom }}</option>
                                @endforeach
                            </select>
                            @error('event_type_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-6">
                            <label class="form-label" for="description">Description</label>
                            <textarea wire:model.defer='description' class="form-control @error('description') is-invalid @enderror"
                                id="description" placeholder="Entrez la description de l'événement"></textarea>
                            @error('description')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-warning me-3" wire:loading.attr="disabled">
                            <span wire:loading.remove>Soumettre</span>
                            <span wire:loading>
                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>
                                Chargement...
                            </span>
                        </button>
                    </div>
                </form>
            @else
                <div class="alert alert-danger text-center">
                    Événement non trouvé.
                </div>
            @endif
        </div>
    </div>

    <div
        wire:loading.class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center">
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
        });
    </script>
@endscript
