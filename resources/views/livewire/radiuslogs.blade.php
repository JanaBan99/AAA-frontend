<div>
    <div wire:loading wire:target="">
        @include('components.spinners.page-loading-indicator')
    </div>
    <div class="container-fluid py-4">
        <div>
            {{-- @include('components.modals.location-modal') --}}
        </div>

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
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white mx-3"><strong> Radius Logs</strong></h6>
                        </div>
                    </div>
                    <div class="row ms-2 me-2 my-3">
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label class="form-label"><span class="text-bold">Filter:</span> (Search entries matching the regular expression)</label>
                                <input type="text" placeholder="Quick Search..." wire:model.debounce.350ms="searchTerm" class="form-control border border-2 p-2">
                            </div>
                        </div>
                        <hr>
                        <form wire:submit.prevent="updateLogs">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label"><span class="text-bold">Row Count:</span> (Number of rows to fetch)</label>
                                        <input type="number" wire:model="rowCount" class="form-control border border-2 p-2">
                                        @error('rowCount') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label"><span class="text-bold">From Date:</span></label>
                                        <input type="datetime-local" wire:model="fromDate" class="form-control border border-2 p-2">
                                        @error('fromDate') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label"><span class="text-bold">To Date:</span></label>
                                        <input type="datetime-local" wire:model="toDate" class="form-control border border-2 p-2">
                                        @error('toDate') <span class="text-danger inputerror">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div>
                                    <button type="submit" class="btn bg-gradient-dark mb-0"><i class="material-icons text-sm"></i>Update</button>
                                </div>
                            </div>

                        </form>

                    </div>
                    <div class="card-body px-0 p-2 m-3">
                        <div class="bg-gray-300 shadow-dark border-radius-lg py-3 pe-1 p-3">
                            @foreach ($linesArray as $line)
                                <p class="text-sm">{{ $line->scalar }}</p>
                            @endforeach
                            @if(count($linesArray) === 0)
                            <p class="no-data-found">No log entries found</p>
                        @endif
                        </div>
                    </div>
                    <div class="p-2">
                        {{$linesArray->links('pagination::bootstrap-5')}}
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
