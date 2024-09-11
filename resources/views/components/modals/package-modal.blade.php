
<!-- Add New Package Modal -->
<div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="packageModal" tabindex="-1" aria-labelledby="packageModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="packageModalLabel">Add New Package</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
            </div>
            <form wire:submit.prevent="addNewPackage">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Package ID</label>
                        <input type="text" placeholder="demo-guest-5x5-20mins-device" wire:model="PKGID" class="form-control border border-2 p-2">
                        @error('PKGID') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Package Name</label>
                        <input type="text" placeholder="Demo 20min (5x5) - 10MB" wire:model="PKGNAME" class="form-control border border-2 p-2">
                        @error('PKGNAME') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Package DESCRIPTION</label>
                        <input type="text" placeholder="Demo 20min (5x5) - 10MB" wire:model="DESCRIPTION" class="form-control border border-2 p-2">
                        @error('DESCRIPTION') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Uplink</label>
                        <input type="number" placeholder="0" wire:model="UPLINK" class="form-control border border-2 p-2">
                        @error('UPLINK') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Downlink</label>
                        <input type="number" placeholder="0" wire:model="DOWNLINK" class="form-control border border-2 p-2">
                        @error('DOWNLINK') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Time Quota</label>
                        <input type="number" placeholder="0" wire:model="TIMEQUOTA" class="form-control border border-2 p-2">
                        @error('TIMEQUOTA') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Volume Quota</label>
                        <input type="number" placeholder="0" wire:model="VOLQUOTA" class="form-control border border-2 p-2">
                        @error('VOLQUOTA') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Idle Timeout</label>
                        <input type="number" placeholder="0" wire:model="IDLETIMEOUT" class="form-control border border-2 p-2">
                        @error('IDLETIMEOUT') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="floatingTextarea2">Other Data</label>
                        <textarea wire:model="OTHERDATA" class="form-control border border-2 p-2"
                                placeholder="{'key1':'value1','key2':'value2'}" id="floatingTextarea2" rows="4"
                                cols="50"></textarea>
                        @error('OTHERDATA') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeModal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Package Update Modal -->
<div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="updatePackageModal" tabindex="-1" aria-labelledby="updatePackageModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="updatePackageModalLabel">Update Package</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
            </div>
            <form wire:submit.prevent="updatePackage" >
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Package ID</label>
                        <input type="text" placeholder="demo-guest-5x5-20mins-device" wire:model="PKGID" class="form-control border border-2 p-2" disabled>
                        @error('PKGID') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Package Name</label>
                        <input type="text" placeholder="Demo 20min (5x5) - 10MB" wire:model="PKGNAME" class="form-control border border-2 p-2">
                        @error('PKGNAME') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Package Description </label>
                        <input type="text" placeholder="Demo 20min (5x5) - 10MB" wire:model="DESCRIPTION" class="form-control border border-2 p-2">
                        @error('DESCRIPTION') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Uplink</label>
                        <input type="number" placeholder="0" wire:model="UPLINK" class="form-control border border-2 p-2">
                        @error('UPLINK') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Downlink</label>
                        <input type="number" placeholder="0" wire:model="DOWNLINK" class="form-control border border-2 p-2">
                        @error('DOWNLINK') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Time Quota</label>
                        <input type="number" placeholder="0" wire:model="TIMEQUOTA" class="form-control border border-2 p-2">
                        @error('TIMEQUOTA') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Volume Quota</label>
                        <input type="number" placeholder="0" wire:model="VOLQUOTA" class="form-control border border-2 p-2">
                        @error('VOLQUOTA') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Idle Timeout</label>
                        <input type="number" placeholder="0" wire:model="IDLETIMEOUT" class="form-control border border-2 p-2">
                        @error('IDLETIMEOUT') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="floatingTextarea2">Other Data</label>
                        <textarea wire:model="OTHERDATA" class="form-control border border-2 p-2"
                                placeholder="{'key1':'value1','key2':'value2'}" id="floatingTextarea2" rows="4"
                                cols="50"></textarea>
                        @error('OTHERDATA') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeModal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!--Package Delete Modal -->
<div wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="deletePackageModal" tabindex="-1" aria-labelledby="deletePackageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="deletePackageModalLabel">Delete Package</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
            </div>
            <div>
                <div class="modal-body">
                    <h6>Are you sure, you want to delete this package?</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="destroyPackage">Yes! Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

