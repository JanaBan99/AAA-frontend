<div class="page-header min-vh-100 w-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 h-100 my-auto pe-0 top-0 start-0 text-center justify-content-center flex-column">
                <div class="h-100 m-3 d-flex flex-column">
                    <div class="d-flex flex-column ms-auto me-auto ms-lg-auto">
                        <div class="d-flex flex-row ms-auto me-auto">
                            <p class="fs-1 fw-bold default-color">{{ $brand === 'wibip' ? 'WiBIP' : ($brand === 'monyfi' ? 'Monyfi' : '') }} AAA</p>
                        </div>
                        <div class="d-flex flex-row ms-auto me-auto  mt-3">
                            <p class="fs-2">Platform to manage Authentication, Authorization and Accounting</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5 justify-content-center">
                <div class="card">
                    <div class="card-header text-center">
                        <img src="{{ asset('assets') }}/img/logos/{{$brand}}.png" class="navbar-brand-img w-70" alt="main_logo">
                        <h4 class="font-weight-bolder">Sign In</h4>
                        <p class="mb-0">Enter your credentials to sign in</p>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent='login'>
                            <div id="alert">
                                @if (Session::has('success-status'))
                                <div class="alert alert-success alert-dismissible text-white" role="alert">
                                    <span class="text-sm">{{ Session::get('success-status') }}</span>
                                    <button type="button" class="btn-close text-lg py-3 opacity-10"
                                        data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @elseif (Session::has('error-status'))
                                <div class="alert alert-danger alert-dismissible text-white" role="alert">
                                    <span class="text-sm">{{ Session::get('error-status') }}</span>
                                    <button type="button" class="btn-close text-lg py-3 opacity-10"
                                        data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @endif
                            </div>
                            <div>
                                <label class="form-label">Username</label>
                                <input wire:model='username' type="text" class="form-control border border-2 p-2">
                            </div>
                            @error('username')
                            <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror

                            <div class="password-container">
                                <label class="form-label">Password</label>
                                <input id="password" wire:model="password" type="password" class="form-control password-input border border-2 p-2">
                                <!-- password show / hide -->
                                {{-- <input id="password" wire:model="password" type="{{ $showPassword ? 'text' : 'password' }}" class="form-control password-input border border-2 p-2">
                                <span wire:click="togglePassword" class="eye-icon-login" for="password">
                                    @if($showPassword)
                                        <i class="fa fa-eye fs-5"></i>
                                    @else
                                        <i class="fa fa-eye-slash fs-5"></i>
                                    @endif
                                </span> --}}
                            </div>
                            @error('password')
                            <p class='text-danger inputerror'>{{ $message }} </p>
                            @enderror
                            @if ($remainingAttempts)
                                <div class="mt-2">
                                    <p>Remaining Attempts: {{$remainingAttempts}}</p>
                                </div>
                            @endif
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary w-100 my-4 mb-2">Sign in
                                    <i wire:loading wire:target="login" class="pl-3 fs-5 fa fa-spinner fa-spin"></i>
                                </button>
                                <p class="mb-0 text-sm text-muted">{{ $brand === 'wibip' ? 'WiBIP' : ($brand === 'monyfi' ? 'Monyfi' : '') }} AAA {{$appVersion}}</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
