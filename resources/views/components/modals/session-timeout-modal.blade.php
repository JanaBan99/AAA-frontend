<!--Session Timeout Modal -->
<div wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="sessionModal" tabindex="-1" aria-labelledby="sessionModalLabel" aria-hidden="true">
    <div wire:loading wire:target="sessionTimedOut">
        @include('components.spinners.full-page-loading-indicator')
    </div>
    <div class="modal-dialog modal-dialog-top">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="sessionModalLabel">Session Timeout</h4>
            </div>
            <div>
                <div class="modal-body">
                    <h6>Your session is about to expire in <span id="countdown">15</span> seconds.</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="extend-session">Extend Session</button>
                    <button type="button" class="btn btn-primary" id="logout">Log Out <i id="spinner" class="pl-3 fs-5 fa fa-spinner fa-spin" style="display: none;"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
