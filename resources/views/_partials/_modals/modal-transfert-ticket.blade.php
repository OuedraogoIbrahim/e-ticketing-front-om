@php
    use Carbon\Carbon;
@endphp
<!-- Transfer Ticket Modal -->
<div wire:ignore.self class="modal fade" id="transferTicketModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple modal-transfer-ticket">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h4 class="mb-2">Transférer un ticket</h4>
                    <p>Transférer votre ticket pour <strong>{{ $ticket['event']['titre'] ?? 'Événement inconnu' }} -
                            {{ isset($ticket['event']['date_debut']) ? Carbon::parse($ticket['event']['date_debut'])->format('d/m/Y') : 'Date inconnue' }}</strong>
                    </p>
                </div>
                <form id="transferTicketForm" class="row g-6"
                    wire:submit.prevent="transferTicket({{ $ticket['id'] ?? 1 }})">
                    <div class="col-12">
                        <label class="form-label" for="modalTransferPhone">Numéro de téléphone</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ti ti-phone ti-20px"></i></span>
                            <input type="tel" id="modalTransferPhone" wire:model.debounce.500ms="phone"
                                class="form-control" placeholder="+123456789" required />
                        </div>
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="modalTransferQuantity">Nombre de tickets</label>
                        <input type="number" id="modalTransferQuantity" wire:model.debounce.500ms="quantity"
                            class="form-control" min="1" max="{{ $ticket['nombre'] ?? 1 }}" placeholder="1"
                            required />
                        @error('quantity')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn me-3" style="background-color: #FF6200; color: white;"
                            wire:confirm="Confirmer le transfert ?|Vous êtes sur le point de transférer ce(s) ticket(s). Cette action est irréversible.|confirmButtonColor:#FF6200|cancelButtonColor:#d33|Oui, transférer !|Annuler"
                            wire:loading.attr="disabled">Envoyer</button>
                        <button type="reset" class="btn btn-label-secondary btn-reset" data-bs-dismiss="modal"
                            aria-label="Close">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div
        wire:loading.class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center z-3">
        <div wire:loading class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Chargement...</span>
        </div>
    </div>
</div>
<!--/ Transfer Ticket Modal -->
