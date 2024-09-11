
<!-- Add New Location Modal -->
<div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="locationModalLabel">Add New Location</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
            </div>
            <form wire:submit.prevent="addNewLocation">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Location ID</label>
                        <input type="text" placeholder="202300000005G1" wire:model="LOCID" class="form-control border border-2 p-2">
                        @error('LOCID') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label>Timezone Offset</label>
                        <input type="text" placeholder="+05:30" wire:model="TIMEZONE_OFFSET" class="form-control border border-2 p-2">
                        @error('TIMEZONE_OFFSET') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="floatingTextarea2">Location Match Entry</label>
                        <textarea wire:model.lazy="LOCATION_MATCH_ENTRY" class="form-control border border-2 p-2"
                                placeholder="{'key1':'value1','key2':'value2'}" id="floatingTextarea2" rows="3"
                                cols="50"></textarea>
                        @error('LOCATION_MATCH_ENTRY') <span class="text-danger inputerror">{{ $message }}</span> @enderror
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

<!-- Location Update Modal -->
<div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="updateLocationModal" tabindex="-1" aria-labelledby="updateLocationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="updateLocationModalLabel">Update Location</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
            </div>
            <form wire:submit.prevent="updateLocation" >
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Location ID</label>
                        <input type="text" placeholder="202300000005G1" wire:model="LOCID" class="form-control border border-2 p-2" disabled>
                        @error('LOCID') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label>Timezone Offset</label>
                        <input type="text" placeholder="+05:30" wire:model="TIMEZONE_OFFSET" class="form-control border border-2 p-2">
                        @error('TIMEZONE_OFFSET') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" id="status" wire:model="STATUS" class="form-control border border-2 p-2">
                            <option value=1>Active</option>
                            <option value=0>Inactive</option>
                        </select>
                        @error('STATUS') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="floatingTextarea2">Location Match Entry</label>
                        <textarea wire:model="LOCATION_MATCH_ENTRY" class="form-control border border-2 p-2"
                                placeholder="{'key1':'value1','key2':'value2'}" id="floatingTextarea2" rows="4"
                                cols="50"></textarea>
                        @error('LOCATION_MATCH_ENTRY') <span class="text-danger inputerror">{{ $message }}</span> @enderror
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


<!--Location Delete Modal -->
<div wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="deleteLocationModal" tabindex="-1" aria-labelledby="deleteLocationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="deleteLocationModalLabel">Delete Location</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
            </div>
            <div>
                <div class="modal-body">
                    <h6>Are you sure, you want to delete this location?</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="destroyLocation">Yes! Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

