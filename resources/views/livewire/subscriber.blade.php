<div>
    <div wire:loading wire:target="addNewSubscriber, updateSubscriber, destroySubscriber">
        @include('components.spinners.page-loading-indicator')
    </div>
    <div class="container-fluid py-4">
        <div>
            @include('components.modals.subscriber-modal')
        </div>

        <div id="alert">
            @if (session()->has('message'))
                {{-- <div class="alert alert-{{ session('status', 'info') }}">
                    <i class="fa fa-check"></i>
                    {{ session('message') }}
                </div> --}}
                <div class="alert alert-{{ session('status', 'info') }} alert-dismissible text-white" role="alert">
                    <span class="text-sm">{{ session('message') }}</span>
                    <button type="button" class="btn-close text-lg py-3 opacity-10" data-bs-dismiss="alert"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white mx-3"><strong> Device Accounts</strong></h6>
                        </div>
                    </div>
                    <div class="row ms-2 me-2 my-3">
                        <div class="col-sm-6">
                            <div class="search-box">
                                <button class="btn-search"><i class="fas fa-search"></i></button>
                                <input type="text" class="input-search" placeholder="Type to Search..." wire:model.debounce.350ms="searchTerm">
                            </div>
                        </div>
                        <div class="col-sm-6 my-auto text-end add-btn-responsive">
                            <button class="btn bg-gradient-dark mb-0" data-bs-toggle="modal" data-bs-target="#subscriberModal"><i
                                class="material-icons text-sm">add</i>Add New Device</button>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <div>
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                USER NAME</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                PASSWORD</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                GROUPID</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                PACKAGE ID</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                VOLUME QUOTA</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                TIME QUOTA</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                STATUS</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                LOCATION ID</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                MAC</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                FIRST LOGIN
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                EXPIRE DATE
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                CREATED DATE
                                            </th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subscribers as $subscriber )
                                            <tr>
                                                <td class="align-middle text-center text-sm">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$subscriber->USERID}}</h6>

                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$subscriber->PASSWORD}}</h6>

                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$subscriber->GROUPID}}</h6>

                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$subscriber->PACKAGEID}}</h6>

                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$subscriber->VOLUMEQTA}}</h6>

                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$subscriber->TIMEQTA}}</h6>

                                                    </div>
                                                </td>
                                                <td class="align-middle text-center">
                                                    @if ( $subscriber->STATUS === 1 )
                                                    <span class="badge badge-sm bg-gradient-success">Active</span>
                                                    @else
                                                    <span class="badge badge-sm bg-gradient-secondary">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$subscriber->LOCID}}</h6>

                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$subscriber->MAC}}</h6>

                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$subscriber->FIRSTLOGIN}}</h6>

                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$subscriber->EXPDATE}}</h6>

                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$subscriber->CREATEDATE}}</h6>

                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="d-flex flex-row justify-content-center">
                                                        <div class="col-6 hand-pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                            <i class="fas fa-edit fs-3" data-bs-toggle="modal" wire:click="editSubscriber({{$subscriber->REFID}})" data-bs-target="#updateSubscriberModal"></i>
                                                        </div>
                                                        <div class="col-6 hand-pointer" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                                            <i class="fa fa-trash fs-3 ms-2" data-bs-toggle="modal" wire:click="deleteSubscriber({{$subscriber->REFID}})" data-bs-target="#deleteSubscriberModal"></i>
                                                        </div>
                                                    </div>

                                                    {{-- <button type="button" rel="tooltip" class="btn btn-success btn-link" data-bs-toggle="modal" wire:click="editLocation({{$location->refId}})" data-bs-target="#updateLocationModal">
                                                        <i class="fas fa-edit fs-4" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i>
                                                        <div class="ripple-container"></div>
                                                    </button></div>
                                                    <button type="button" rel="tooltip" class="btn btn-danger btn-link"  data-bs-toggle="modal" wire:click="deleteLocation({{$location->refId}})" data-bs-target="#deleteLocationModal">
                                                        <i class="material-icons fs-4" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">delete</i>
                                                        <div class="ripple-container"></div>
                                                    </button> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                                @if(count($subscribers) === 0)
                                    <p class="no-data-found">No devices found</p>
                                @endif
                            </div>

                            <div class="p-2">
                                {{$subscribers->links('pagination::bootstrap-5')}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .no-data-found {
            padding: 50px;
            color: #888;
            font-size: 24px;
            text-align: center;
        }

        /*  search button css  */
        .search-box{
            width: fit-content;
            height: fit-content;
            position: relative;
        }
        .input-search{
            height: 50px;
            width: 50px;
            border-style: none;
            padding: 10px;
            font-size: 18px;
            letter-spacing: 2px;
            outline: none;
            border-radius: 25px;
            transition: all .5s ease-in-out;
            background-color: #c7c1c774;
            padding-right: 40px;
            color:black;
        }
        .input-search::placeholder{
            color:#888;
            font-size: 18px;
            letter-spacing: 2px;
            font-weight: 100;
        }
        .btn-search{
            width: 50px;
            height: 50px;
            border-style: none;
            font-size: 20px;
            font-weight: bold;
            outline: none;
            cursor: pointer;
            border-radius: 50%;
            position: absolute;
            right: 0px;
            color:black ;
            background-color:transparent;
            pointer-events: painted;
        }
        .btn-search:focus ~ .input-search{
            width: 250px;
            border-radius: 0px;
            color:black ;
            background-color: transparent;
            border-bottom:1px solid #888;
            transition: all 500ms cubic-bezier(0, 0.110, 0.35, 2);
        }
        .input-search:focus{
            width: 300px;
            border-radius: 0px;
            background-color: transparent;
            border-bottom:1px solid #888;
            transition: all 500ms cubic-bezier(0, 0.110, 0.35, 2);
        }
    </style>
@endpush
