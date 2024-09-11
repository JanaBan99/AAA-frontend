<!--Logout Modal -->
<div wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div wire:loading wire:target="logout">
        @include('components.spinners.full-page-loading-indicator')
    </div>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="logoutModalModalLabel">Sign Out</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
            </div>
            <div>
                <div class="modal-body">
                    <h6>Are you sure, you want to sign out?</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" wire:click="logout">Yes <i wire:loading wire:target="destroy" class="pl-3 fs-5 fa fa-spinner fa-spin"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
