@php
    $brand = session('brand'); // Retrieve the brand from session or set a default value
@endphp
<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
            <a class="navbar-brand text-center" href="{{ route('dashboard') }}">
                <img src="{{ asset('assets') }}/img/logos/{{$brand}}.png" class="navbar-brand-img w-80" alt="main_logo">
            </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white {{ Route::currentRouteName() == 'dashboard' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Accounts</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ Route::currentRouteName() == 'locations' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('locations') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">place</i>
                    </div>
                    <span class="nav-link-text ms-1">Locations</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Route::currentRouteName() == 'packages' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('packages') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">inventory</i>
                    </div>
                    <span class="nav-link-text ms-1">Packages</span>
                </a>
            </li>
            <li class="nav-item">
                <a id="subscribers-tab" class="nav-link text-white"
                    href="#">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">people</i>
                    </div>
                    <span class="nav-link-text ms-1">Subscribers</span>
                    <i id="expand-icon" class="material-icons opacity-10 text-m ms-6">expand_more</i>
                </a>
            </li>
            <li id="device-accounts-tab" class="nav-item d-none ms-3">
                <a class="nav-link text-white {{ Route::currentRouteName() == 'masters' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('masters') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">fiber_manual_record</i>
                    </div>
                    <span class="nav-link-text ms-1">Master Accounts</span>
                </a>
            </li>
            <li id="subscriber-accounts-tab" class="nav-item d-none ms-3">
                <a class="nav-link text-white {{ Route::currentRouteName() == 'devices' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('devices') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">fiber_manual_record</i>
                    </div>
                    <span class="nav-link-text ms-1">Device Accounts</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Logs</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Route::currentRouteName() == 'aaalogs' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('aaalogs') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">library_books</i>
                    </div>
                    <span class="nav-link-text ms-1">AAA Logs</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Route::currentRouteName() == 'radiuslogs' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('radiuslogs') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">library_books</i>
                    </div>
                    <span class="nav-link-text ms-1">Radius Logs</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link text-white {{ Route::currentRouteName() == 'billing' ? ' active bg-gradient-primary' : '' }}  "
                    href="{{ route('billing') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">receipt_long</i>
                    </div>
                    <span class="nav-link-text ms-1">Billing</span>
                </a>
            </li> --}}
            {{-- <li class="nav-item">
                <a class="nav-link text-white {{ Route::currentRouteName() == 'virtual-reality' ? ' active bg-gradient-primary' : '' }}  "
                    href="{{ route('virtual-reality') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">view_in_ar</i>
                    </div>
                    <span class="nav-link-text ms-1">Virtual Reality</span>
                </a>
            </li> --}}
            {{-- <li class="nav-item">
                <a class="nav-link text-white {{ Route::currentRouteName() == 'rtl' ? ' active bg-gradient-primary' : '' }}  "
                    href="{{ route('rtl') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
                    </div>
                    <span class="nav-link-text ms-1">RTL</span>
                </a>
            </li> --}}
            {{-- <li class="nav-item">
                <a class="nav-link text-white {{ Route::currentRouteName() == 'notifications' ? ' active bg-gradient-primary' : '' }}  "
                    href="{{ route('notifications') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">notifications</i>
                    </div>
                    <span class="nav-link-text ms-1">Notifications</span>
                </a>
            </li> --}}
            {{-- <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account pages</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Route::currentRouteName() == 'profile' ? ' active bg-gradient-primary' : '' }}  "
                    href="{{ route('profile') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ route('static-sign-in') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">login</i>
                    </div>
                    <span class="nav-link-text ms-1">Sign In</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ route('static-sign-up') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">assignment</i>
                    </div>
                    <span class="nav-link-text ms-1">Sign Up</span>
                </a>
            </li> --}}
        </ul>
    </div>
    <!--div class="sidenav-footer position-absolute w-100 bottom-0 ">
        <div class="mx-3">
            <a class="btn bg-gradient-primary w-100" href="https://www.creative-tim.com/product/material-dashboard-laravel-livewire" target="_blank">Free Download</a>
        </div>
        <div class="mx-3">
            <a class="btn bg-gradient-primary w-100" href="../../documentation/getting-started/installation.html" target="_blank">View documentation</a>
        </div>
        <div class="mx-3">
            <a class="btn bg-gradient-primary w-100"
                href="https://www.creative-tim.com/product/material-dashboard-pro-laravel-livewire" target="_blank" type="button">Upgrade
                to pro</a>
        </div>
    </div-->
</aside>

