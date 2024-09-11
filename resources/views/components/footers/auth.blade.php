@php
    $brand = session('brand'); // Retrieve the brand from session
    $appVersion = config('app.version');
@endphp
<footer class="footer py-4  ">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col mb-lg-0 mb-4">
                <div class="copyright text-center text-sm text-muted">
                    © <script>
                        document.write(new Date().getFullYear())

                    </script>,
                    {{ $brand === 'wibip' ? 'WiBIP' : ($brand === 'monify' ? 'Monify' : '') }} AAA {{$appVersion}}
                </div>
            </div>
        </div>
    </div>
</footer>
