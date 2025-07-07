<div class="container">
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="mb-0 form-title-orange">Ajouter un événement</h5>
        </div>
        <div class="card-body p-6">
            <form class="add-new-event pt-0" id="addNewEventForm" wire:submit='submit'>
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
                        <label class="form-label" for="date_fin">Date de fin <span class="text-danger">*</span></label>
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
                            placeholder="Entrez le nombre_tickets" />
                        @error('nombre_tickets')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-6">
                        <label class="form-label" for="type">Type <span class="text-danger">*</span></label>
                        <select name="type" wire:model.defer='event_type_id'
                            class="form-select @error('event_type_id') is-invalid @enderror" id="type">
                            <option value="">Selectionner un type</option>
                            @foreach ($types as $t)
                                <option value="{{ $t->id }}">{{ $t->nom }}</option>
                            @endforeach
                        </select>
                        @error('type')
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
                    <button type="submit" class="btn btn-orange me-3" wire:loading.attr="disabled">
                        <span wire:loading.remove>Soumettre</span>
                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Chargement...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
