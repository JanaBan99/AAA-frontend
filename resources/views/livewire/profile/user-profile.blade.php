<div>
    <div wire:loading wire:target="updateProfile, updatePassword">
        @include('components.spinners.page-loading-indicator')
    </div>
    <div class="container-fluid px-2 px-md-4">
        <div id="alert">
            @if (session()->has('message'))
                <div class="alert alert-{{ session('status', 'info') }} alert-dismissible text-white" role="alert">
                    <span class="text-sm">{{ session('message') }}</span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
        <div class="card card-body mx-3 mx-md-4 mt-6">
            <div class="row gx-4 mb-3">
                <div class="col-auto">
                    <div class="avatar avatar-xxl position-relative">
                        <img src="{{ asset('assets') }}/img/profile-logo.png" alt="profile_image"
                            class="w-100 border-radius-lg shadow-sm">
                    </div>
                </div>
                <div class="col-auto my-auto ms-3">
                    <div class="h-100">
                        <h5 class="row mb-1">
                            {{$userNameTop}}
                        </h5>
                        <p class="row mb-0 font-weight-normal text-sm">
                            Created At: {{$createDate}}
                        </p>
                        <p class="row mb-0 font-weight-normal text-sm">
                            Last Update: {{$lastUpdate}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="tab-content mt-3">
                <div id="profile-content">
                    <div class="card card-plain h-100">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-md-8 d-flex align-items-center">
                                    <h6 class="mb-3">Profile Management</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <form wire:submit.prevent='updateProfile'>
                                <div class="row">

                                    <div class="mb-3 col-md-6">

                                        <label class="form-label">Username</label>
                                        <input wire:model="USERNAME" type="text" class="form-control border border-2 p-2">
                                        @error('USERNAME')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6">

                                        <label class="form-label">Email</label>
                                        <input wire:model="EMAIL" type="text" class="form-control border border-2 p-2">
                                        @error('EMAIL')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6">

                                        <label class="form-label">Phone</label>
                                        <input wire:model="PHONE" type="text" class="form-control border border-2 p-2">
                                        @error('PHONE')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6">

                                        <label class="form-label">Status</label>
                                        <select name="status" id="status" wire:model="IS_ENABLE" class="form-control border border-2 p-2" disabled>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                        @error('IS_ENABLE')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn bg-gradient-dark">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="password-content">
                    <div class="card card-plain h-100">
                        <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-md-8 d-flex align-items-center">
                                    <h6 class="mb-3">Password Management</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <form wire:submit.prevent='updatePassword'>
                                <div class="col">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">New Password</label>
                                        <input id="password" wire:model="NEW_PASSWORD" type="password" class="form-control border border-2 p-2">
                                        @error('NEW_PASSWORD')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Confirm Password</label>
                                        <input id="confirm_password" wire:model="CONFIRM_PASSWORD" type="password" class="form-control border border-2 p-2">
                                        @error('CONFIRM_PASSWORD')
                                        <p class='text-danger inputerror'>{{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn bg-gradient-dark">Update Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@push('styles')
    <style>
        .tab-content > .tab-pane {
            display: none;
        }
        .tab-content > .tab-pane.active {
            display: block;
        }
    </style>
@endpush
