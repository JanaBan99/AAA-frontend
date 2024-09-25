<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
// use Livewire\WithPagination;
use stdClass;
use App\Models\LocationModel;
use Carbon\Carbon;

class Location extends Component
{
    // use WithPagination;
    public $locationArray;
    public $locationData;
    public $deleteLocationId = '';
    public $page;
    public $LOCID, $TIMEZONE_OFFSET, $LOCATION_MATCH_ENTRY, $STATUS;
    public $searchTerm = '';
    public $brand;
    public $refId;

    protected $messages = [
        'LOCID.max' => 'The location id must be shorter than or equal to 30 characters',
        'LOCID.regex' => 'The location id must not contain special characters',
        'TIMEZONE_OFFSET.regex' => 'The timezone offset must be a valid time zone offset in the format +/-hh:mm',
        'LOCATION_MATCH_ENTRY.json' => 'The location match entry must be a valid JSON object.',
        'STATUS.in' => 'Invalid status value'
    ];

    protected function rules(){
        return [
            'LOCID' => ['required', 'max:30', 'regex:/^[a-zA-Z0-9.]*$/'],
            'TIMEZONE_OFFSET' => ['required', 'regex:/^([+-])(0[0-9]|1[0-4]):[0-5][0-9]$/'],
            'STATUS' => ['required', 'integer', 'in:0,1'],
            'LOCATION_MATCH_ENTRY' => ['required', 'json' ]
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function addNewLocation(){
        $validatedData = $this->validate();

        // Create postData associative array
        $postData = [];

        foreach ($validatedData as $key => $value) {
            if ($key === 'LOCATION_MATCH_ENTRY') {
                $postData[$key] = json_decode($value);
            } else {
                $postData[$key] = $value;
            }
        }

        // Add additional fields
        $postData['GROUPID'] = $this->brand;
        $postData['NASID'] = $this->brand;
        $postData['STATUS'] = 1;
        $postData['CREATEDATE'] = Carbon::now()->format('Y-m-d H:i:s'); // Format the date as string

        try {
            $record = LocationModel::where('LOCID', $postData['LOCID'])->first();
            if ($record) {
                session()->flash('message','Location Id already exists');
                session()->flash('status', 'danger');
                $this->dispatchBrowserEvent('close-modal');
                $this->dispatchBrowserEvent('close-alert');
            } else {
                LocationModel::create($postData);
                session()->flash('message','Location created successfully');
                session()->flash('status', 'success');
                $this->resetInput();
                $this->dispatchBrowserEvent('close-modal');
                $this->dispatchBrowserEvent('close-alert');
                $this->getLocations();
            }

        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function editLocation($REFID){
        $this->refId = $REFID;
        $location = array_filter($this->locationArray, function ($location) use ($REFID){
            return $location["REFID"] === $REFID;
        });
        $arrayVales = array_values($location);
        $data = $arrayVales[0];
        // dump($data);
        if($location){
            $this->LOCID = $data['LOCID'];
            $this->TIMEZONE_OFFSET = $data['TIMEZONE_OFFSET'];
            $this->STATUS = $data['STATUS'];
            $this->LOCATION_MATCH_ENTRY = json_encode($data['LOCATION_MATCH_ENTRY']);
        }else{
            return redirect()->to('/locations');
        }
    }

    public function updateLocation(){
        $validatedData = $this->validate();

        // Create updateData associative array
        $updateData = [];

        foreach ($validatedData as $key => $value) {
            if ($key === 'LOCATION_MATCH_ENTRY') {
                $updateData[$key] = json_decode($value);
            }else if($key === 'STATUS'){
                $updateData[$key] = intval($value);
            }else {
                $updateData[$key] = $value;
            }
        }

        try {
            // Check if the record exists
            $record = LocationModel::where('REFID', $this->refId)->first();
            if($record){
                // Update the existing record
                $record->update($updateData);
                session()->flash('message','Location updated successfully');
                session()->flash('status', 'success');
                $this->resetInput();
                $this->dispatchBrowserEvent('close-modal');
                $this->dispatchBrowserEvent('close-alert');
                $this->getLocations();
            }else{
                session()->flash('message','Location not found');
                session()->flash('status', 'danger');
                $this->dispatchBrowserEvent('close-modal');
                $this->dispatchBrowserEvent('close-alert');
            }

        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function closeModal(){
        $this->resetInput();
    }

    public function resetInput(){
        $this->LOCID = "";
        $this->TIMEZONE_OFFSET = "";
        $this->STATUS = 1;
        $this->LOCATION_MATCH_ENTRY = "";
    }

    public function deleteLocation($REFID){

        $this->deleteLocationId = $REFID;

    }

    public function destroyLocation(){
        $record = LocationModel::find($this->deleteLocationId);

        if ($record) {
            $record->delete();
            session()->flash('message','Location deleted successfully');
            session()->flash('status', 'success');
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('close-alert');
            $this->getLocations();
        } else {
            session()->flash('message', 'Location not found' );
            session()->flash('status', 'danger');
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('close-alert');
        }
    }

    public function mount(){
        $this->searchTerm = '';
        $this->brand = session('brand');
        $this->getLocations();
    }

    public function getLocations(){
        // Retrieve data from the database and convert to an array of objects
        $this->locationData = LocationModel::where('GROUPID', $this->brand)
            ->latest('CREATEDATE')
            ->get()
            ->map(function ($item) {
                return (object) $item->toArray();
            })->toArray();
    }

    public function render()
    {

        $this->locationArray = $this->locationData;
        if(!$this->locationArray){
            $this->locationArray = [];
        }
        ///If user search some string, this code block triggers
        $searchTerm = $this->searchTerm;
        if($searchTerm !== '' || $searchTerm !== null){

            $results = array_filter($this->locationArray, function ($obj) use ($searchTerm) {
                foreach ($obj as $property => $value) {
                    if (is_string($value) && strpos($value, $searchTerm) !== false) {
                        return true;
                    }
                }
                return false;
            });

            //Convert to object collection
            $results = collect($results);
            $results = $results->map(function ($item) {
                return (object) $item;
            })->toArray();
            $this->locationArray = $results;
        }

        //Data rendering to the blade with pagination
        $perPage = 5;
        $this->page = request("page") ?? $this->page;
        $rawCollection = $this->locationArray;
        $fixedCollection = new Collection();
        if (gettype($rawCollection) == "array") {
            foreach($rawCollection as $key => $val) {
                $fixedCollection->put($key, $val);
            }
        } else {
            $fixedCollection = $rawCollection;
        }

        //If there are no records in current page in paginator when delete records, the page redirects to page one
        $items = $fixedCollection->forPage($this->page, $perPage);
        if($items->count() === 0){
            $this->page = 1;
            $items = $fixedCollection->forPage($this->page, $perPage);
        }
        $paginator = new LengthAwarePaginator($items, $fixedCollection->count(), $perPage, $this->page, ['path' => url('locations')]);
        return view('livewire.location', ['locations' => $paginator]);
    }
}
