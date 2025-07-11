<div>
    <div class="card">
        <div class="m-5">
            @if (session()->has('message'))
                <div class="alert alert-info">
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
        </div>

        <div class="card-header border-bottom">
            <h5 class="card-title mb-0">Liste des Agents</h5>
        </div>

        <div class="row m-5">
            <div class="col-md-12">
                <div
                    class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-6 mb-md-0 mt-n6 mt-md-0">
                    <div class="dt-buttons btn-group flex-wrap">
                        <button class="btn btn-warning add-new btn-warning waves-effect waves-light mb-4" tabindex="0"
                            aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal"
                            data-bs-target="#addAgentModal">
                            <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                                    class="d-none d-sm-inline-block">Ajouter un agent</span></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-datatable table-responsive">
            <table class="datatables-users table">
                <thead class="border-top">
                    <tr>
                        <th>Nom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if (empty($agents))
                        <tr>
                            <td colspan="2" class="text-center text-muted">Aucun agent trouvé.</td>
                        </tr>
                    @else
                        @foreach ($agents as $agent)
                            <tr>
                                <th>{{ $agent['nom'] }}</th>
                                <td class="d-flex align-items-center">
                                    <button wire:click="editAgent('{{ $agent['id'] }}')"
                                        class="btn btn-sm btn-icon edit-record btn-text-secondary rounded-pill waves-effect"
                                        data-bs-toggle="modal" data-bs-target="#editAgentModal">
                                        <i class="ti ti-edit"></i>
                                    </button>
                                    <a href="javascript:void(0);" onclick="confirmDelete(event, '{{ $agent['id'] }}')"
                                        class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill delete-record">
                                        <i class="ti ti-trash ti-md"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Modal pour ajouter un agent -->
        <div class="modal fade" id="addAgentModal" tabindex="-1" aria-labelledby="addAgentModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAgentModalLabel">Ajouter un agent</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit="createAgent">
                            <div class="mb-3">
                                <label for="addNom" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" wire:model.defer="nom"
                                    class="form-control @error('nom') is-invalid @enderror" id="addNom"
                                    placeholder="Entrez le nom de l'agent">
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="addPassword" class="form-label">Mot de passe <span
                                        class="text-danger">*</span></label>
                                <input type="password" wire:model.defer="password"
                                    class="form-control @error('password') is-invalid @enderror" id="addPassword"
                                    placeholder="Entrez le mot de passe">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                    <span wire:loading.remove>Créer</span>
                                    <span wire:loading>
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        Chargement...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal pour modifier un agent -->
        <div wire:ignore.self class="modal fade" id="editAgentModal" tabindex="-1"
            aria-labelledby="editAgentModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAgentModalLabel">Modifier un agent</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="updateAgent">
                            <div class="mb-3">
                                <label for="editNom" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" wire:model.defer="nom"
                                    class="form-control @error('nom') is-invalid @enderror" id="editNom"
                                    placeholder="Entrez le nom de l'agent">
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="editPassword" class="form-label">Mot de passe (facultatif)</label>
                                <input type="password" wire:model.defer="password"
                                    class="form-control @error('password') is-invalid @enderror" id="editPassword"
                                    placeholder="Entrez un nouveau mot de passe">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                    <span wire:loading.remove>Modifier</span>
                                    <span wire:loading>
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        Chargement...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div
            wire:loading.class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center">
            <div wire:loading class="sk-chase sk-primary">
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
                <div class="sk-chase-dot"></div>
            </div>
        </div> --}}

        <script>
            function confirmDelete(event, agentId) {
                event.preventDefault();
                Swal.fire({
                    title: 'Êtes-vous sûr ?',
                    text: 'Vous ne pourrez pas revenir en arrière !',
                    imageUrl: "{{ asset('assets/lordicon/delete.gif') }}",
                    imageWidth: 100,
                    imageHeight: 100,
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Oui, supprimer !',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('deleteAgent', agentId);
                    }
                });
            }
        </script>
    </div>


</div>

@script
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Gestion des messages
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

            // Gestion des modals
            const editModal = new bootstrap.Modal('#editAgentModal');

            Livewire.on('open-edit-modal', () => {
                editModal.show();
            });

            Livewire.on('close-edit-modal', () => {
                editModal.hide();
            });

            // Fermeture du modal après succès
            Livewire.on('agent-updated', () => {
                editModal.hide();
            });
        });

        function confirmDelete(event, agentId) {
            event.preventDefault();
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: 'Vous ne pourrez pas revenir en arrière !',
                imageUrl: "{{ asset('assets/lordicon/delete.gif') }}",
                imageWidth: 100,
                imageHeight: 100,
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimer !',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('deleteAgent', agentId);
                }
            });
        }
    </script>
@endscript
