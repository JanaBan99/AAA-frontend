<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use stdClass;
use App\Models\MasterModel;
use Carbon\Carbon;
use App\Models\PackageModel;
use Illuminate\Support\Facades\DB;
use App\Models\LocationModel;
use App\Models\SubscriberModel;

class Master extends Component
{
    public $masterArray;
    public $masterData;
    public $deleteMasterId = '';
    public $page;
    public $USERID, $PASSWORD,$GROUPID, $PACKAGEID, $STATUS, $LOCID, $FIRST_NAME, $LAST_NAME, $PHONE, $EMAIL, $VOLUMEQTA, $TOKEN_REF, $USERPROFILE, $EXPDATE, $CREATEDATE, $LASTUPDATE;
    public $searchTerm = '';
    public $refId;
    public $oldPackageId = '';

    protected $messages = [
        'PASSWORD.max' => 'The password must be shorter than or equal to 60 characters',
        'PACKAGEID.max' => 'The package id must be shorter than or equal to 64 characters',
        'STATUS.in' => 'Invalid status value',
        'LOCID.max' => 'The location id must be shorter than or equal to 30 characters',
        'FIRST_NAME.max' => 'The first name must be shorter than or equal to 30 characters',
        'FIRST_NAME.regex' => 'The first name must not contain special characters except dash, underscore, single quotes and spaces',
        'LAST_NAME.max' => 'The last name must be shorter than or equal to 30 characters',
        'LAST_NAME.regex' => 'The last name must not contain special characters except dash, underscore, single quotes and spaces',
        'PHONE.regex' => 'The phone number must be a valid 10-digit phone number (ex:- xxx-xxx-xxxx)',
        'EMAIL.regex' => 'Invalid email address'
    ];

    protected function rules(){
        return [
            'USERID' => ['required'],
            'PASSWORD' => ['required', 'max:60'],
            'PACKAGEID' => ['required', 'max:64'],
            'STATUS' => ['required', 'integer', 'in:0,1'],
            'LOCID' => ['required', 'max:30'],
            'FIRST_NAME' => ['max:30', 'regex:/^[a-zA-Z0-9\s\-_\'\']+$/'],
            'LAST_NAME' => ['max:30', 'regex:/^[a-zA-Z0-9\s\-_\'\']+$/'],
            'PHONE' => ['regex:/^\d{3}-\d{3}-\d{4}$/'],
            'EMAIL' => ['regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
            'TOKEN_REF' => [],
            'USERPROFILE' => [],
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function addNewMaster(){
            $validatedData = $this->validate();
            // Create postData associative array
            $postData = [];
            foreach ($validatedData as $key => $value) {
                if($key === "STATUS"){
                    //status value convert to int
                    $postData[$key] = intval($value);
                }else if($key === "PASSWORD"){
                    $postData[$key] = $this->hashInputString($value);
                }else{
                    $postData[$key] = $value;
                }
            }

            $package = PackageModel::where('PKGID', $postData['PACKAGEID'])
                                ->where('GROUPID', $this->brand)
                                ->first();

            if($package){
                // Add additional fields
                $postData['GROUPID'] = $this->brand;
                $postData['VOLUMEQTA'] = $package->VOLQUOTA;
                $postData['EXPDATE'] = $this->getExpireDate((int) $package->TIMEQUOTA);
                $postData['CREATEDATE'] = Carbon::now()->format('Y-m-d H:i:s');
                $postData['LASTUPDATE'] = Carbon::now()->format('Y-m-d H:i:s');

                $location = LocationModel::where('LOCID', $postData['LOCID'])
                                        ->where('GROUPID', $this->brand)
                                        ->first();
                if($location){
                    $record = MasterModel::where('USERID', $postData['USERID'])->first();
                    if ($record) {
                        session()->flash('message','User ID already exists');
                        session()->flash('status', 'danger');
                        $this->dispatchBrowserEvent('close-modal');
                        $this->dispatchBrowserEvent('close-alert');
                    } else {
                        MasterModel::create($postData);
                        session()->flash('message','Master account created successfully');
                        session()->flash('status', 'success');
                        $this->resetInput();
                        $this->dispatchBrowserEvent('close-modal');
                        $this->dispatchBrowserEvent('close-alert');
                        $this->getMasters();
                    }
                }else{
                    session()->flash('message','Invalid location ID');
                    session()->flash('status', 'danger');
                    $this->dispatchBrowserEvent('close-modal');
                    $this->dispatchBrowserEvent('close-alert');
                }

            }else{
                $errorMsg = 'Invalid package ID';
                session()->flash('message',$errorMsg);
                session()->flash('status', 'danger');
                $this->dispatchBrowserEvent('close-modal');
                $this->dispatchBrowserEvent('close-alert');
            }
    }

    public function hashInputString($value)
    {
         // Perform the SHA-1 hash using a raw SQL query with parameter binding
        $query = "SELECT SHA1(?) as hash";
        $result = DB::select($query, [$value]);

        // Check if result is not empty and return the hash
        if (!empty($result)) {
            return $result[0]->hash;
        } else {
            return '';
        }
    }

    public function getExpireDate($timeQuota)
    {
        // Perform the calculation using raw SQL query
        $query = "SELECT DATE_ADD(NOW(), INTERVAL ? SECOND) as expdate";
        $result = DB::select($query, [$timeQuota]);

        // Check if result is not empty and set the expiry date
        if (!empty($result)) {
            return $result[0]->expdate;
        } else {
            return null;
        }
    }

    public function editMaster($REFID){
        $this->refId = $REFID;
        $master = array_filter($this->masterArray, function ($master) use ($REFID){
            return $master["REFID"] === $REFID;
        });
        $arrayVales = array_values($master);
        $data = $arrayVales[0];
        if($master){
            $this->USERID = $data['USERID'];
            $this->PASSWORD = $data['PASSWORD'];
            $this->PACKAGEID = $data['PACKAGEID'];
            $this->STATUS = $data['STATUS'];
            $this->LOCID = $data['LOCID'];
            $this->TOKEN_REF = $data['TOKEN_REF'];
            $this->FIRST_NAME = $data['FIRST_NAME'];
            $this->LAST_NAME = $data['LAST_NAME'];
            $this->PHONE = $data['PHONE'];
            $this->EMAIL = $data['EMAIL'];
            $this->USERPROFILE = $data['USERPROFILE'];
            $this->oldPackageId = $data['PACKAGEID'];
        }else{
            return redirect()->to('/masters');
        }
    }

    public function updateMaster(){
        $validatedData = $this->validate();

        // Create postData associative array
        $postData = [];
        foreach ($validatedData as $key => $value) {
            if($key === "STATUS"){
                //status value convert to int
                $postData[$key] = intval($value);
            }else{
                $postData[$key] = $value;
            }
        }

        $location = LocationModel::where('LOCID', $postData['LOCID'])
                                        ->where('GROUPID', $this->brand)
                                        ->first();
        if($location){
            // Check if the record exists
            $record = MasterModel::where('REFID', $this->refId)->first();
            if($record){

                $postData['LASTUPDATE'] = Carbon::now()->format('Y-m-d H:i:s');

                //Master account packge update

                if($this->oldPackageId === $postData['PACKAGEID']){
                    //If the user not changed the master package Id, update columns without VOLUMEQTA, EXPDATE

                    // Update the existing record
                    $record->update($postData);
                    session()->flash('message','Master account updated successfully');
                    session()->flash('status', 'success');
                    $this->resetInput();
                    $this->dispatchBrowserEvent('close-modal');
                    $this->dispatchBrowserEvent('close-alert');
                    $this->getMasters();
                }else{
                    //If the user changed the master package Id, update the columns VOLUMEQTA, EXPDATE and change related device account's VOLUMEQTA, EXPDATE

                    $newPackage = PackageModel::where('PKGID', $postData['PACKAGEID'])
                                    ->where('GROUPID', $this->brand)
                                    ->first();
                    if($newPackage){
                        $postData['EXPDATE'] = $this->getExpireDate((int) $newPackage->TIMEQUOTA);
                        $record->update($postData);

                        //After updating master package, related device account's pacakges should be renewed.
                        $devices = SubscriberModel::where('MASTER_USER', $postData['USERID'])->get();
                        $devicesArray = $devices->toArray();
                        if($devicesArray){
                            $currentDateTime = Carbon::now()->format('Y-m-d H:i:s');
                            foreach ($devicesArray as $device) {
                                if($device['EXPDATE'] < $currentDateTime){ // If package expired
                                    $deviceData['VOLUMEQTA'] = $newPackage->VOLQUOTA;
                                    $deviceData['EXPDATE'] = $this->getExpireDate((int) $newPackage->TIMEQUOTA);
                                }else{
                                    $deviceData['VOLUMEQTA'] = $this->calculateVolumeQuota(1, $device, $newPackage->VOLQUOTA);
                                    $calculatedTimeQta = $this->calculateTimeQuota(1, $device, $newPackage->TIMEQUOTA);
                                    $deviceData['EXPDATE'] = $this->getExpireDate((int) $calculatedTimeQta);
                                }
                                $deviceData['PACKAGEID'] = $postData['PACKAGEID'];
                                $updateDevice = SubscriberModel::where('USERID', $device['USERID'])->first();
                                if($updateDevice){
                                    $updateDevice->update($deviceData);
                                }
                            }

                            session()->flash('message','Master account updated successfully');
                            session()->flash('status', 'success');
                            $this->resetInput();
                            $this->dispatchBrowserEvent('close-modal');
                            $this->dispatchBrowserEvent('close-alert');
                            $this->getMasters();

                        }else{
                            session()->flash('message','Master account updated successfully');
                            session()->flash('status', 'success');
                            $this->resetInput();
                            $this->dispatchBrowserEvent('close-modal');
                            $this->dispatchBrowserEvent('close-alert');
                            $this->getMasters();
                        }

                    }else{
                        $errorMsg = 'Invalid package ID';
                        session()->flash('message',$errorMsg);
                        session()->flash('status', 'danger');
                        $this->dispatchBrowserEvent('close-modal');
                        $this->dispatchBrowserEvent('close-alert');
                    }
                }
            }else{
                session()->flash('message','Master account not found');
                session()->flash('status', 'danger');
                $this->dispatchBrowserEvent('close-modal');
                $this->dispatchBrowserEvent('close-alert');
            }
        }else{
            session()->flash('message','Invalid location ID');
            session()->flash('status', 'danger');
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('close-alert');
        }

    }

    public function calculateVolumeQuota($rechargeKey, $device, $newPkgVolQuota)
    {
        if ($rechargeKey === 1) {
            $existingPkg = PackageModel::where('PKGID', $device['PACKAGEID'])->first();
            if ($existingPkg) {
                $usedVolQuota = $existingPkg->VOLQUOTA - $device['VOLUMEQTA'];
                $updatedVolQuota = $newPkgVolQuota - $usedVolQuota;

                if ($updatedVolQuota < 0) {
                    return 0;
                } else {
                    return $updatedVolQuota;
                }
            }

            return 0; // Handle case where package data is not found
        }

        return 0; // Handle other cases or defaults
    }

    public function calculateTimeQuota($rechargeKey, $device, $newPkgTimeQuota)
    {
        if ($rechargeKey === 1) {
            $existingPkg = PackageModel::where('PKGID', $device['PACKAGEID'])->first();
            if ($existingPkg) {
                $usedTimeQuota = $existingPkg->TIMEQUOTA - $device['TIMEQTA'];
                $updatedTimeQuota = $newPkgTimeQuota - $usedTimeQuota;

                if ($updatedTimeQuota < 0) {
                    return 0;
                } else {
                    return $updatedTimeQuota;
                }
            }

            return 0; // Handle case where package data is not found
        }

        return 0; // Handle other cases or defaults
    }

    public function closeModal(){
        $this->resetInput();
    }

    public function resetInput(){
        $this->USERID = '';
        $this->PASSWORD= '';
        $this->PACKAGEID= '';
        $this->STATUS= 1;
        $this->LOCID= '';
        $this->FIRST_NAME= '';
        $this->LAST_NAME= '';
        $this->PHONE= '';
        $this->EMAIL= '';
        $this->TOKEN_REF= '';
        $this->USERPROFILE= '';
    }

    public function deleteMaster($REFID){
        $this->deleteMasterId = $REFID;
    }

    public function destroyMaster(){
        $record = MasterModel::find($this->deleteMasterId);

        if ($record) {
            $record->delete();
            session()->flash('message','Master account deleted successfully');
            session()->flash('status', 'success');
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('close-alert');
            $this->getmasters();
        } else {
            session()->flash('message', 'Master account not found' );
            session()->flash('status', 'danger');
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('close-alert');
        }

    }

    public function mount(){
        $this->searchTerm = '';
        $this->brand = session('brand');
        $this->getMasters();
    }

    public function getMasters(){
        // Retrieve data from the database and convert to an array of objects
        $this->masterData = MasterModel::where('GROUPID', $this->brand)
        ->latest('CREATEDATE')
        ->get()
        ->map(function ($item) {
            return (object) $item->toArray();
        })->toArray();

    }

    public function render()
    {

        //Unset USERPROFILE object from the data
        // for($i=0; $i <= count((array)$this->masterData)-1; $i++){
        //     if (isset($this->masterData[$i]->USERPROFILE)) {
        //         unset($this->masterData[$i]->USERPROFILE);
        //     }
        // }

        $this->masterArray = $this->masterData;
        if(!$this->masterArray){
            $this->masterArray = [];
        }
        // dump($this->masterArray);
        // dump($this->masterArray);
        //If user search some string, this code block triggers
        $searchTerm = $this->searchTerm;
        if($searchTerm !== '' || $searchTerm !== null){

            $results = array_filter($this->masterArray, function ($obj) use ($searchTerm) {
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
            $this->masterArray = $results;
        }
        // dump($this->masterArray);
        //Data rendering to the blade with pagination
        $perPage = 10;
        $this->page = request("page") ?? $this->page;
        $rawCollection = $this->masterArray;
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
        $paginator = new LengthAwarePaginator($items, $fixedCollection->count(), $perPage, $this->page, ['path' => url('masters')]);
        return view('livewire.master', ['masters' => $paginator]);

    }

}
