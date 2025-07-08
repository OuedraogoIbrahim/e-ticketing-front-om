<section class="section-py bg-body first-section-pt">
    <div class="container">
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($event)
            <div class="card px-3">
                <div class="row">
                    <div class="col-lg-7 card-body border-end p-md-8">
                        <h4 class="mb-2">Paiement par Orange Money</h4>
                        <p class="mb-0">Procédez au paiement des tickets pour l'événement:
                            <strong>{{ $event['titre'] }}</strong>
                        </p>

                        <div class="row g-5 py-8">
                            <div class="col-12">
                                <div class="form-check custom-option custom-option-basic checked">
                                    <label
                                        class="form-check-label custom-option-content form-check-input-payment d-flex gap-4 align-items-center">
                                        <input name="paymentMethod" class="form-check-input" type="radio"
                                            value="orange-money" checked />
                                        <span class="custom-option-body">
                                            <img src="{{ asset('assets/img/orange-money-logo.jpg') }}"
                                                alt="orange-money" width="58">
                                            <span class="ms-4 fw-medium text-heading">Orange Money</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <h4 class="mb-6">Informations de paiement</h4>
                        <form wire:submit.prevent="purchase">
                            <div class="row g-6">
                                <div class="col-md-6">
                                    <label class="form-label" for="nombre_tickets">Nombre de tickets</label>
                                    <input type="number" id="nombre_tickets"
                                        class="form-control @error('nombre_tickets') is-invalid @enderror"
                                        wire:model.live.debounce.500ms="nombre_tickets" min="1"
                                        max="{{ $event['tickets_disponibles'] ?? 1 }}" required />
                                    @error('nombre_tickets')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="phone">Numéro Orange Money</label>
                                    <input wire:model.live.debounce.500ms="telephone" type="tel" id="phone"
                                        class="form-control @error('telephone') is-invalid @enderror" placeholder=""
                                        required />
                                    @error('telephone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-grid mt-5">
                                <button type="submit" class="btn btn-success" wire:loading.attr="disabled">
                                    <span class="me-2">Payer avec Orange Money</span>
                                    <i class="ti ti-arrow-right scaleX-n1-rtl"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-5 card-body p-md-8">
                        <h4 class="mb-2">Récapitulatif de commande</h4>
                        <p class="mb-8">Détails de votre achat de tickets.</p>

                        <div class="bg-lighter p-6 rounded">
                            <p>Événement: <strong>{{ $event['titre'] }}</strong></p>
                            <p>Prix unitaire: <strong>{{ number_format($event['prix'], 0, ',', ' ') }}
                                    FCFA</strong></p>
                            <p>Nombre de tickets: <strong>{{ $nombre_tickets ? $nombre_tickets : 1 }}</strong></p>

                            <div class="d-flex align-items-center mb-4">
                                <h1 class="text-heading mb-0">
                                    {{ number_format($event['prix'] * ($nombre_tickets ? $nombre_tickets : 1), 0, ',', ' ') }}
                                    FCFA</h1>
                            </div>
                        </div>

                        <div class="mt-5">
                            <hr>
                            <div class="d-flex justify-content-between align-items-center mt-4 pb-1">
                                <p class="mb-0">Total à payer</p>
                                <h6 class="mb-0">
                                    {{ number_format($event['prix'] * ($nombre_tickets ? $nombre_tickets : 1), 0, ',', ' ') }}
                                    FCFA
                                </h6>
                            </div>
                        </div>

                        <p class="mt-8">En continuant, vous acceptez nos conditions générales de vente.
                            Les paiements sont non remboursables.</p>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-danger text-center">
                Événement non trouvé.
            </div>
        @endif

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
</section>

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
