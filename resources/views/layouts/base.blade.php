<!DOCTYPE html>
<html lang='en' dir="{{ Route::currentRouteName() == 'rtl' ? 'rtl' : '' }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{-- <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets') }}/img/logo.png"> --}}
    <link rel="icon" type="image/png" href="{{ asset('assets') }}/img/logos/{{$brand}}.png">
    <title>
        {{ $brand === 'wibip' ? 'WiBIP' : ($brand === 'monyfi' ? 'Monyfi' : '') }} AAA
    </title>

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets') }}/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    {{-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets') }}/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('styles')
    @livewireStyles
</head>
<body class="g-sidenav-show {{Route::currentRouteName() == 'login' ? '' : 'bg-gray-200' }}">

{{ $slot }}

<script src="{{ asset('assets') }}/js/core/popper.min.js"></script>
<script src="{{ asset('assets') }}/js/core/bootstrap.min.js"></script>
<script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
<script src="{{ asset('assets') }}/js/plugins/smooth-scrollbar.min.js"></script>
@stack('js')
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }

</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('assets') }}/js/material-dashboard.min.js?v=3.0.0"></script>
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
    //Modals JS
    window.addEventListener('close-modal', event => {
        $('#locationModal').modal('hide');
        $('#updateLocationModal').modal('hide');
        $('#deleteLocationModal').modal('hide');
        $('#packageModal').modal('hide');
        $('#updatePackageModal').modal('hide');
        $('#deletePackageModal').modal('hide');
        $('#subscriberModal').modal('hide');
        $('#updateSubscriberModal').modal('hide');
        $('#deleteSubscriberModal').modal('hide');
        $('#masterModal').modal('hide');
        $('#updateMasterModal').modal('hide');
        $('#deleteMasterModal').modal('hide');
    })

    //Alert JS
    window.addEventListener('close-alert', event => {
        //Hide alerts in 5 seconds
        var alert = document.getElementById("alert");

        if (alert) {
            setTimeout(function () {
                alert.style.display = "none";
            }, 5000);
        }
    })

    //Side bar JS
    document.addEventListener('DOMContentLoaded', function() {
        var subscribersTab = document.getElementById('subscribers-tab');
        var subscriberAccountsTab = document.getElementById('subscriber-accounts-tab');
        var deviceAccountsTab = document.getElementById('device-accounts-tab');
        var expandIcon = document.getElementById('expand-icon');

        // Check if the current route is 'subscriber' or 'master'
        var currentRoute = "{{ Route::currentRouteName() }}";
        if (currentRoute === 'devices' || currentRoute === 'masters') {
            subscriberAccountsTab.classList.remove('d-none');
            deviceAccountsTab.classList.remove('d-none');
            expandIcon.innerText = 'expand_less';
        }

        // Toggle visibility of the additional tabs
        subscribersTab.addEventListener('click', function(event) {
            event.preventDefault();
            subscriberAccountsTab.classList.toggle('d-none');
            deviceAccountsTab.classList.toggle('d-none');

            // Toggle the expand/collapse icon
            if (subscriberAccountsTab.classList.contains('d-none')) {
                expandIcon.innerText = 'expand_more';
            } else {
                expandIcon.innerText = 'expand_less';
            }
        });


    });

    //Idle Timeout JS
    window.isAuthenticated = @json(Auth::check());
    window.isSessionExpired = true;

    document.addEventListener('DOMContentLoaded', function () {
        if (window.isAuthenticated) {
            var logoutTime = 15 * 60 * 1000;  // Total inactivity time before logout (15 minutes)
            var countdownTime = 60 * 1000;    // Countdown time for popup in seconds
            var warningTime = logoutTime - countdownTime;
            var warningShown = false;
            var timeout;
            var countdownInterval;
            var modalVisible = false;

            function resetTimer() {
                if (!modalVisible) { // Only reset timer if modal is not visible
                    clearTimeout(timeout);
                    clearInterval(countdownInterval);
                    warningShown = false;
                    timeout = setTimeout(showWarning, warningTime);
                }
            }

            function showWarning() {
                if (!warningShown) {
                    warningShown = true;
                    modalVisible = true;

                    // Show the session modal
                    var sessionModal = new bootstrap.Modal(document.getElementById('sessionModal'));
                    sessionModal.show();

                    // Start countdown timer
                    var countdownElement = document.getElementById('countdown');
                    var secondsLeft = countdownTime / 1000;

                    countdownInterval = setInterval(function () {
                        secondsLeft -= 1;
                        countdownElement.textContent = secondsLeft;
                        if (secondsLeft <= 0) {
                            clearInterval(countdownInterval);
                            //Disable session extend and logout buttons when session has expired
                            document.getElementById('extend-session').disabled = true;
                            document.getElementById('logout').disabled = true;
                            // Auto logout if the countdown reaches zero
                            Livewire.emit('sessionTimedOut');

                        }
                    }, 1000);

                    // Handle Extend Session button click
                    document.getElementById('extend-session').addEventListener('click', function () {
                        sessionModal.hide(); // Hide the modal
                        modalVisible = false; // Reset modal visibility
                        resetTimer(); // Reset timer after session extension
                    });

                    // Handle Log Out button click
                    document.getElementById('logout').addEventListener('click', function () {
                        var spinner = document.getElementById('spinner');
                        Livewire.emit('logout');

                        //Disable session extend and logout buttons when session has expired
                        document.getElementById('extend-session').disabled = true;
                        document.getElementById('logout').disabled = true;
                        spinner.style.display = 'inline-block'; //Show spinner

                        modalVisible = false;
                    });
                }
            }

            if(!warningShown){
                // Listen for user activity
                document.addEventListener('mousemove', resetTimer);
                document.addEventListener('keypress', resetTimer);
                document.addEventListener('click', resetTimer);

                // Initialize timer
                resetTimer();
            }

        }

    });
</script>
@livewireScripts
</body>
</html>
