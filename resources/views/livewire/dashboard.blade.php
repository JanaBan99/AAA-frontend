<div>
      <!-- Navbar -->
      <!-- End Navbar -->
      <div class="container-fluid py-4">
          <div class="row">
            <!--div class="col-xxl-3 col-xl-6 col-sm-6 mb-xxl-0 mb-4">
                <div class="card min-vh-25 justify-content-center">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">miscellaneous_services</i>
                        </div>
                        <div class="text-center pt-5">
                            <p class="text-xl mb-0 text-capitalize">Total Services</p>
                            <h1 class="mb-0">{{count($services)}}</h1>
                        </div>
                    </div>
                    <div class="card-footer p-3">
                    </div>
                </div>
            </div-->
            <div class="col-xxl-3 col-xl-6 col-sm-6 mb-xxl-0 mb-4">
                <div class="card min-vh-25 justify-content-center">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-primary shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">dns</i>
                        </div>
                        <div class="text-center pt-5">
                            @if (!empty($services))
                                <table class="mx-auto">
                                    <tbody>
                                        @foreach($services as $service)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <h6 class="mb-0 text-sm">{{ $service['unit'] }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-sm text-center">
                                                    @if ($service['active_state'] === 'active')
                                                        <i class="material-icons opacity-10 text-success cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="right" title="Active">fiber_manual_record</i>
                                                    @else
                                                        <i class="material-icons opacity-10 text-danger cursor-pointer" data-bs-toggle="tooltip" data-bs-placement="right" title="Inactive">fiber_manual_record</i>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No service information available.</p>
                            @endif
                        </div>

                    </div>
                    <div class="card-footer p-3">
                        <p class="mb-0">Services</p>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-6 col-sm-6 mb-xxl-0 mb-4">
                <div class="card min-vh-25 justify-content-center">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-primary shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">dns</i>
                        </div>
                        <div class="text-center pt-5">
                            <p class="text-xl mb-0 text-capitalize">Primary Server</p>
                            <h2 class="mb-0">{{$serverIp}}</h2>
                        </div>
                    </div>
                    <div class="card-footer p-3">
                        <p class="mb-0">Server Status: <span class="text-success text-sm font-weight-bolder">Online</span></p>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-6 col-sm-6 mb-xxl-0 mb-4">
                <div class="card min-vh-25 justify-content-center">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-success shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">timer</i>
                        </div>
                        <div class="text-center pt-5">
                            {{-- <p class="text-xl mb-0 text-capitalize">Server Uptime</p> --}}
                            {{-- <h2 class="mb-0">3.15.254.99</h2> --}}
                            <div class="row">
                                <div class="col ps-0" >
                                    <div class="row">
                                        <h6>{{$days}}</h6>
                                    </div>
                                    <div class="row">
                                       <p>Days</p>
                                    </div>
                                </div>
                                <div class="col ps-0" >
                                    <div class="row">
                                        <h6>{{$hours}}</h6>
                                    </div>
                                    <div class="row">
                                        <p>Hours</p>
                                    </div>
                                </div>
                                <div class="col ps-0" >
                                    <div class="row">
                                        <h6>{{$minutes}}</h6>
                                    </div>
                                    <div class="row">
                                        <p>Minutes</p>
                                    </div>
                                </div>
                                <div class="col ps-0" >
                                    <div class="row">
                                        <h6>{{$seconds}}</h6>
                                    </div>
                                    <div class="row">
                                        <p>Seconds</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-2">
                        <p class="mb-0">Server Uptime</p>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-6 col-sm-6 mb-xxl-0 mb-4">
                <div class="card min-vh-25 justify-content-center">
                    <div class="card-header p-3 pt-2">
                        <div
                            class="icon icon-lg icon-shape bg-gradient-info shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">today</i>
                        </div>
                        <div class="text-center pt-5">
                            <p class="text-xl mb-0 text-capitalize">Current Time</p>
                            <h2 class="mb-0" id="currentTime">{{ $currentTime }}</h2>
                        </div>
                    </div>
                    <div class="card-footer p-3">
                        <p class="mb-0">{{ $currentDate }}</p>
                    </div>
                </div>
            </div>
          </div>
          <div class="row mt-4">
              <div class="col-lg-4 col-md-6 mt-4 mb-4">
                  <div class="card z-index-2 widget-min-h">
                      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                          {{-- <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                              <div class="chart">
                                  <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                              </div>
                          </div> --}}
                          <ul class="list-group">
                            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-300 shadow-dark border-radius-lg py-3 pe-1 canvas-min-h">
                                <div class="d-flex flex-column">
                                    <span class="mb-3 text-xs mt-3">Server Hostname: <span
                                            class="text-dark font-weight-bold ms-sm-2">{{$hostname}}</span></span>
                                    <span class="mb-3 text-xs">Server IP: <span
                                            class="text-dark ms-sm-2 font-weight-bold">{{$serverIp}}</span></span>
                                    <span class="mb-3 text-xs">Operating System: <span
                                            class="text-dark ms-sm-2 font-weight-bold">{{$operatingSystem}}</span></span>
                                    <span class="mb-3 text-xs">Webserver: <span
                                        class="text-dark ms-sm-2 font-weight-bold">{{$webServer}}</span></span>
                                    <span class="mb-3 text-xs">CPU: <span
                                        class="text-dark ms-sm-2 font-weight-bold">{{$cpuModel}}</span></span>
                                </div>
                            </li>
                          </ul>
                      </div>
                      <div class="card-body">
                          <h6 class="mb-0 ">Server Information</h6>
                          {{-- <p class="text-sm ">Last Campaign Performance</p> --}}
                      </div>
                  </div>
              </div>
              <div class="col-lg-4 col-md-6 mt-4 mb-4">
                  <div class="card z-index-2 widget-min-h">
                      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                          <div class="bg-gray-300 shadow-dark border-radius-lg py-3 pe-1 canvas-min-h">
                              <div class="chart">
                                  <canvas id="chart-disk" class="chart-canvas" height="150"></canvas>
                              </div>
                          </div>
                      </div>
                      <div class="card-body">
                          <h6 class="mb-0 "> Disk Information</h6>
                          <p class="text-sm "><span class="font-weight-bolder">Total Space: </span>{{$diskTotal}}</p>
                          <p class="text-sm "><span class="font-weight-bolder">Used Space: </span>{{$diskUsed}}</p>
                          <p class="text-sm "><span class="font-weight-bolder">Remaining Space: </span>{{$diskFree}}</p>
                          <p class="text-sm "><span class="font-weight-bolder">Used Percentage: </span>{{$diskUsedPercentage}}%</p>
                      </div>
                  </div>
              </div>
              <div class="col-lg-4 mt-4 mb-3">
                  <div class="card z-index-2 widget-min-h">
                      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                          <div class="bg-gray-300 shadow-dark border-radius-lg py-3 pe-1 canvas-min-h">
                              <div class="chart">
                                  <canvas id="chart-memory" class="chart-canvas" height="150"></canvas>
                              </div>
                          </div>
                      </div>
                      <div class="card-body">
                          <h6 class="mb-0 ">Memory Information</h6>
                          <p class="text-sm "><span class="font-weight-bolder">Total Memory: </span>{{$totalMemory}}</p>
                          <p class="text-sm "><span class="font-weight-bolder">Used Memory: </span>{{$usedMemory}}</p>
                          <p class="text-sm "><span class="font-weight-bolder">Remaining Memory: </span>{{$freeMemory}}</p>
                          <p class="text-sm "><span class="font-weight-bolder">Used Percentage: </span>{{$memoryUsagePercentage}}%</p>                      </div>
                  </div>
              </div>
          </div>
          <!-- div class="row mt-1">
            <div class="col-xxl-8 mt-2 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h6>Services</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive table-wrapper ">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Unit</th>
                                            <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Load State</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            State</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Sub State</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($services as $service)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $service['unit'] }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold">{{ $service['load_state'] }}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            @if ( $service['active_state'] === 'active' )
                                            <span class="badge badge-sm bg-gradient-success">Active</span>
                                            @else
                                            <span class="badge badge-sm bg-gradient-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="text-xs font-weight-bold">{{ $service['sub_state'] }}</span>
                                        </td>
                                        <td class="text-sm">
                                            <span class="text-xs font-weight-bold">{{ $service['description'] }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if(count($services) === 0)
                                    <p class="no-data-found">No data found</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
          </div -->
      </div>
  </div>
  </div>
@push('js')
  <script src="{{ asset('assets') }}/js/plugins/chartjs.min.js"></script>
  <script>

    var ctx4 = document.getElementById("chart-disk").getContext("2d");

    new Chart(ctx4, {
        type: "doughnut", // Change type to doughnut for the gauge appearance
        data: {
            labels: ["Disk Space Used", "Remaining Disk Space"],
            datasets: [{
                data: [@json($diskUsed).split(' ')[0], @json($diskFree).split(' ')[0]],
                backgroundColor: [
                    "rgba(40, 167, 69, 0.8)", // Color for used disk space
                    "rgba(54, 162, 235, 0.2)"  // Color for remaining disk space
                ],
                borderWidth: 0,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '55%', // Adjust to set the inner cutout of the doughnut chart
            plugins: {
                legend: {
                    display: true,
                }
            },
            elements: {
                arc: {
                    borderWidth: 0,
                }
            },
            animation: {
                animateScale: true,
                animateRotate: true
            },
            tooltips: {
                enabled: false
            }
        },
    });

    var ctx4 = document.getElementById("chart-memory").getContext("2d");

    new Chart(ctx4, {
        type: "doughnut", // Change type to doughnut for the gauge appearance
        data: {
            labels: ["Memory Space Used", "Remaining Memory Space"],
            datasets: [{
                data: [@json($usedMemory).split(' ')[0], @json($freeMemory).split(' ')[0]],
                backgroundColor: [
                    "rgba(40, 167, 69, 0.8)", // Color for used disk space
                    "rgba(54, 162, 235, 0.2)"  // Color for remaining disk space
                ],
                borderWidth: 0,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '55%', // Adjust to set the inner cutout of the doughnut chart
            plugins: {
                legend: {
                    display: true,
                }
            },
            elements: {
                arc: {
                    borderWidth: 0,
                }
            },
            animation: {
                animateScale: true,
                animateRotate: true
            },
            tooltips: {
                enabled: false
            }
        },
    });

    //Current time widget
    document.addEventListener('livewire:load', function () {
        Livewire.on('updateTime', () => {
            // Update current time including seconds
            const currentTimeElement = document.getElementById('currentTime');
            currentTimeElement.innerText = new Date().toLocaleTimeString('en-US', { hour12: false });

            // Schedule next update after 1 second
            setTimeout(() => {
                Livewire.emit('updateTime');
            }, 1000); // 1000 milliseconds = 1 second
        });

        // Start updating time initially
        Livewire.emit('updateTime');
    });

  </script>
@endpush
@push('styles')
    <style>
        .canvas-min-h {
            min-height: 200px;
        }

        .widget-min-h {
            min-height: 400px;
        }

        .no-data-found {
            padding: 50px;
            color: #888;
            font-size: 15px;
            text-align: center;
        }

        /* CSS for table wrapper */
        .table-wrapper {
            max-height: 400px; /* Adjust this value as needed */
            overflow-y: auto;
        }

    </style>
@endpush
