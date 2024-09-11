
<!-- Add New Subscriber Modal -->
<div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="subscriberModal" tabindex="-1" aria-labelledby="subscriberModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="subscriberModalLabel">Add New Device</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
            </div>
            <form wire:submit.prevent="addNewSubscriber">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" placeholder="CA6D661AD7BC990110000036G1" wire:model="USERID" class="form-control border border-2 p-2">
                                @error('USERID') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="text" placeholder="********" wire:model="PASSWORD" class="form-control border border-2 p-2">
                                @error('PASSWORD') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label>Package ID</label>
                                <input type="text" placeholder="demo-guest-100x100-6hours-device" wire:model="PACKAGEID" class="form-control border border-2 p-2">
                                @error('PACKAGEID') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label>Status</label>
                                {{-- <input type="text" wire:model="status" class="form-control border border-2 p-2"> --}}
                                <select name="status" id="status" wire:model="STATUS" class="form-control border border-2 p-2">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                @error('STATUS') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label>MAC</label>
                                <input type="text" placeholder="CA-6D-66-1A-D7-BC" wire:model="MAC" class="form-control border border-2 p-2">
                                @error('MAC') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label>Location ID</label>
                                <input type="text" placeholder="202300000005" wire:model="LOCID" class="form-control border border-2 p-2">
                                @error('LOCID') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label>Department</label>
                                <input type="text" placeholder="Department" wire:model="DEPARTMENT" class="form-control border border-2 p-2">
                                @error('DEPARTMENT') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="text" placeholder="abc@gmail.com" wire:model="EMAIL" class="form-control border border-2 p-2">
                                @error('EMAIL') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label>Captive Token</label>
                                <input type="text" placeholder="a6011f8c396ae31129b83f63f9cd4359" wire:model="TOKEN_REF" class="form-control border border-2 p-2">
                                @error('TOKEN_REF') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label>First Name</label>
                                <input type="text" placeholder="John" wire:model="FIRST_NAME" class="form-control border border-2 p-2">
                                @error('FIRST_NAME') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label>Last Name</label>
                                <input type="text" placeholder="Charlie" wire:model="LAST_NAME" class="form-control border border-2 p-2">
                                @error('LAST_NAME') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label>Phone</label>
                                <input type="text" wire:model="PHONE" class="form-control border border-2 p-2">
                                @error('PHONE') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <label for="floatingTextarea1">User Profile</label>
                            <textarea wire:model.lazy="USERPROFILE" class="form-control border border-2 p-2"
                                    placeholder="{'key1':'value1','key2':'value2'}" id="floatingTextarea1" rows="3"
                                    cols="50"></textarea>
                            @error('USERPROFILE') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                        </div>
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

<!-- Subscriber Update Modal -->
<div wire:ignore.self class="modal fade" data-bs-backdrop="static" id="updateSubscriberModal" tabindex="-1" aria-labelledby="updateSubscriberModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="updateSubscriberModalLabel">Update Device</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
            </div>
            <form wire:submit.prevent="updateSubscriber">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" placeholder="CA6D661AD7BC990110000036G1" wire:model="USERID" class="form-control border border-2 p-2">
                                @error('USERID') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="text" placeholder="********" wire:model="PASSWORD" class="form-control border border-2 p-2">
                                @error('PASSWORD') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label>Package ID</label>
                                <input type="text" placeholder="demo-guest-100x100-6hours-device" wire:model="PACKAGEID" class="form-control border border-2 p-2">
                                @error('PACKAGEID') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label>Status</label>
                                {{-- <input type="text" wire:model="status" class="form-control border border-2 p-2"> --}}
                                <select name="status" id="status" wire:model="STATUS" class="form-control border border-2 p-2">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                                @error('STATUS') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label>MAC</label>
                                <input type="text" placeholder="CA-6D-66-1A-D7-BC" wire:model="MAC" class="form-control border border-2 p-2">
                                @error('MAC') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label>Location ID</label>
                                <input type="text" placeholder="202300000005" wire:model="LOCID" class="form-control border border-2 p-2">
                                @error('LOCID') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label>Department</label>
                                <input type="text" placeholder="Department" wire:model="DEPARTMENT" class="form-control border border-2 p-2">
                                @error('DEPARTMENT') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="text" placeholder="abc@gmail.com" wire:model="EMAIL" class="form-control border border-2 p-2">
                                @error('EMAIL') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label>Captive Token</label>
                                <input type="text" placeholder="a6011f8c396ae31129b83f63f9cd4359" wire:model="TOKEN_REF" class="form-control border border-2 p-2">
                                @error('TOKEN_REF') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label>First Name</label>
                                <input type="text" placeholder="John" wire:model="FIRST_NAME" class="form-control border border-2 p-2">
                                @error('FIRST_NAME') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label>Last Name</label>
                                <input type="text" placeholder="Charlie" wire:model="LAST_NAME" class="form-control border border-2 p-2">
                                @error('LAST_NAME') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label>Phone</label>
                                <input type="text" wire:model="PHONE" class="form-control border border-2 p-2">
                                @error('PHONE') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <label for="floatingTextarea1">User Profile</label>
                            <textarea wire:model.lazy="USERPROFILE" class="form-control border border-2 p-2"
                                    placeholder="{'key1':'value1','key2':'value2'}" id="floatingTextarea1" rows="3"
                                    cols="50"></textarea>
                            @error('USERPROFILE') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeModal">Close</button>
                    <button type="submit" class="btn btn-primary" wire:click="updateSubscriber">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!--Subscriber Delete Modal -->
<div wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="deleteSubscriberModal" tabindex="-1" aria-labelledby="deleteSubscriberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="deleteLocationModalLabel">Delete Device</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
            </div>
            <div>
                <div class="modal-body">
                    <h6>Are you sure, you want to delete this device?</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click="destroySubscriber">Yes! Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

