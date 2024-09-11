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
use App\Models\PackageModel;
use Carbon\Carbon;

class Package extends Component
{
    // use WithPagination;
    public $packageArray;
    public $deletePackageId = '';
    public $page;
    public $PKGID, $PKGNAME, $DESCRIPTION, $UPLINK, $DOWNLINK, $TIMEQUOTA, $VOLQUOTA, $IDLETIMEOUT, $GROUPID, $OTHERDATA, $CREATEDATE;
    public $searchTerm = '';
    public $brand;
    public $refId;

    protected $messages = [
        'PKGID.max' => 'The package id must be shorter than or equal to 64 characters',
        'PKGID.regex' => 'The package id must not contain special characters except -',
        'PKGID.regex1' => 'The package id must not contain spaces',
        'PKGNAME.max' => 'The package name must be shorter than or equal to 128 characters',
        'DESCRIPTION.max' => 'The description must be shorter than or equal to 128 characters',
        'UPLINK.max' => 'The uplink must be shorter than or equal to 10 digits',
        'DOWNLINK.max' => 'The downlink must be shorter than or equal to 10 digits',
        'TIMEQUOTA.max' => 'The time quota must be shorter than or equal to 10 digits',
        'VOLQUOTA.max' => 'The volume quota must be shorter than or equal to 19 digits',
        'IDLETIMEOUT.max' => 'The idle timeout must be shorter than or equal to 10 digits',
        'OTHERDATA.json' => 'The other data field must be a valid JSON object.',

    ];

    protected function rules(){
        return [
            'PKGID' => ['required', 'max:64', 'regex:/^[^!@#\\$%^&*()_+\\[\\]{};\\":\\\\|,.<>\\/?]*-?[^!@#\\$%^&*()_+\\[\\]{};\\":\\\\|,.<>\\/?]*$/', 'regex:/^[^\s]+$/'],
            'PKGNAME' => ['required', 'max:128'],
            'DESCRIPTION' => ['required', 'max:128'],
            'UPLINK' => ['required','max:10'],
            'DOWNLINK' => ['required','max:10'],
            'TIMEQUOTA' => ['required','max:10'],
            'VOLQUOTA' => ['required','max:19'],
            'IDLETIMEOUT' => ['required','max:10'],
            'OTHERDATA' => ['required', 'json' ]
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function addNewPackage(){
        $validatedData = $this->validate();

        $postData = [];
        foreach ($validatedData as $key => $value) {
            if($key === "UPLINK" || $key === "DOWNLINK" || $key === "TIMEQUOTA"  || $key === "VOLQUOTA" || $key === "IDLETIMEOUT" ){
                $postData[$key]= (int)$value;
            }else{
                $postData[$key] = $value;
            }
        }

        // Add additional fields
        $postData['GROUPID'] = $this->brand;
        $postData['CREATEDATE'] = Carbon::now()->format('Y-m-d H:i:s');


        try {

            $record = PackageModel::where('PKGID', $postData['PKGID'])->first();

            if ($record) {
                session()->flash('message','Package Id already exists');
                session()->flash('status', 'danger');
                $this->dispatchBrowserEvent('close-modal');
                $this->dispatchBrowserEvent('close-alert');
            } else {
                PackageModel::create($postData);
                session()->flash('message','Package created successfully');
                session()->flash('status', 'success');
                $this->resetInput();
                $this->dispatchBrowserEvent('close-modal');
                $this->dispatchBrowserEvent('close-alert');
                $this->getPackages();
            }

        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function editPackage($REFID){
        $this->refId = $REFID;
        $package = array_filter($this->packageArray, function ($package) use ($REFID){
            return $package["REFID"] === $REFID;
        });
        $arrayVales = array_values($package);
        $data = $arrayVales[0];
        if($package){
            $this->PKGID = $data['PKGID'];
            $this->PKGNAME = $data['PKGNAME'];
            $this->DESCRIPTION = $data['DESCRIPTION'];
            $this->UPLINK = $data['UPLINK'];
            $this->DOWNLINK = $data['DOWNLINK'];
            $this->TIMEQUOTA = $data['TIMEQUOTA'];
            $this->VOLQUOTA = $data['VOLQUOTA'];
            $this->IDLETIMEOUT = $data['IDLETIMEOUT'];
            $this->OTHERDATA = $data['OTHERDATA'];
        }else{
            return redirect()->to('/packages');
        }
    }

    public function updatePackage(){
        $validatedData = $this->validate();

        $postData = [];
        foreach ($validatedData as $key => $value) {
            if($key === "UPLINK" || $key === "DOWNLINK" || $key === "TIMEQUOTA"  || $key === "VOLQUOTA" || $key === "IDLETIMEOUT" ){
                $postData[$key]= (int)$value;
            }else{
                $postData[$key] = $value;
            }
        }

        try {
            // Check if the record exists
            $record = PackageModel::where('REFID', $this->refId)->first();
            if($record){
                // Update the existing record
                $record->update($postData);
                session()->flash('message','Package updated successfully');
                session()->flash('status', 'success');
                $this->resetInput();
                $this->dispatchBrowserEvent('close-modal');
                $this->dispatchBrowserEvent('close-alert');
                $this->getPackages();
            }else{
                session()->flash('message','Package not found');
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
        $this->PKGID = "";
        $this->PKGNAME = "";
        $this->DESCRIPTION = "";
        $this->UPLINK = "";
        $this->DOWNLINK = "";
        $this->TIMEQUOTA = "";
        $this->VOLQUOTA = "";
        $this->IDLETIMEOUT = "";
        $this->OTHERDATA = "";
    }

    public function deletePackage($REFID){
        $this->deletePackageId = $REFID;
    }

    public function destroyPackage(){
        $record = PackageModel::find($this->deletePackageId);

        if ($record) {
            $record->delete();
            session()->flash('message','Package deleted successfully');
            session()->flash('status', 'success');
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('close-alert');
            $this->getPackages();
        } else {
            session()->flash('message', 'Package not found' );
            session()->flash('status', 'danger');
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('close-alert');
        }

    }

    public function mount(){
        $this->searchTerm = '';
        $this->brand = session('brand');
        $this->getPackages();
    }

    public function getPackages(){
        // Retrieve data from the database and convert to an array of objects
        $this->packageData = PackageModel::where('GROUPID', $this->brand)
        ->latest('CREATEDATE')
        ->get()
        ->map(function ($item) {
            return (object) $item->toArray();
        })->toArray();
    }

    public function render()
    {

        $this->packageArray = $this->packageData;
        if(!$this->packageArray){
            $this->packageArray = [];
        }

        ///If user search some string, this code block triggers
        $searchTerm = $this->searchTerm;
        if($searchTerm !== '' || $searchTerm !== null){

            $results = array_filter($this->packageArray, function ($obj) use ($searchTerm) {
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
            $this->packageArray = $results;
        }

        //Data rendering to the blade with pagination
        $perPage = 6;
        $this->page = request("page") ?? $this->page;
        $rawCollection = $this->packageArray;
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
        $paginator = new LengthAwarePaginator($items, $fixedCollection->count(), $perPage, $this->page, ['path' => url('packages')]);
        return view('livewire.package', ['packages' => $paginator]);

    }

}
