<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use stdClass;
use App\Models\SubscriberModel;
use Carbon\Carbon;
use App\Models\PackageModel;
use Illuminate\Support\Facades\DB;
use App\Models\LocationModel;

class Subscriber extends Component
{
    // use WithPagination;
    public $subscriberArray;
    public $subscriberData;
    public $deleteSubscriberId = '';
    public $page;
    public $USERID, $PASSWORD,$GROUPID, $PACKAGEID, $STATUS, $MAC, $LOCID, $DEPARTMENT, $FIRST_NAME, $LAST_NAME, $PHONE, $EMAIL, $VOLUMEQTA, $TIMEQTA, $FIRSTLOGIN, $EXPDATE, $CREATEDATE, $USERPROFILE, $TOKEN_REF;
    public $searchTerm = '';
    public $brand;
    public $refId;

    protected $messages = [
        'USERID.max' => 'The username must be shorter than or equal to 30 characters',
        'USERID.regex' => 'The username must not contain special characters except @',
        'USERID.regex1' => 'The username must not contain spaces',
        'PASSWORD.max' => 'The password must be shorter than or equal to 30 characters',
        'PACKAGEID.max' => 'The package id must be shorter than or equal to 64 characters',
        'MAC.regex' => 'Invalid mac address',
        'LOCID.max' => 'The location id must be shorter than or equal to 30 characters',
        'DEPARTMENT.max' => 'The department must be shorter than or equal to 30 characters',
        'USERPROFILE.json' => 'The user profile must be a valid JSON object',
        'FIRST_NAME.max' => 'The first name must be shorter than or equal to 30 characters',
        'FIRST_NAME.regex' => 'The first name must not contain special characters except dash, underscore, single quotes and spaces',
        'LAST_NAME.max' => 'The last name must be shorter than or equal to 30 characters',
        'LAST_NAME.regex' => 'The last name must not contain special characters except dash, underscore, single quotes and spaces',
        'EMAIL.regex' => 'Invalid email address',
        'PHONE.regex' => 'The phone number must be a valid 10-digit phone number (ex:- xxx-xxx-xxxx)'
    ];

    protected function rules(){
        return [
            'USERID' => ['required', 'max:30', 'regex:/^[^!@#$%^&*()_+=[\]{};\'\\:\"\\|,.<>\/?]*@?[^!@#$%^&*()_+=[\]{};\'\\:\"\\|,.<>\/?]*$/', 'regex:/^[^\s]+$/'],
            'PASSWORD' => ['required', 'max:30'],
            'PACKAGEID' => ['required', 'max:64'],
            'STATUS' => ['required'],
            'MAC' => ['required', 'regex:/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$|^([0-9A-Fa-f]{12})$/'],
            'LOCID' => ['required', 'max:30'],
            'DEPARTMENT' => ['max:30'],
            'USERPROFILE' => ['json'],
            'TOKEN_REF' => [],
            'FIRST_NAME' => ['max:30', 'regex:/^[a-zA-Z0-9\s\-_\'\']+$/'],
            'LAST_NAME' => ['max:30', 'regex:/^[a-zA-Z0-9\s\-_\'\']+$/'],
            'PHONE' => ['regex:/^\d{3}-\d{3}-\d{4}$/'],
            'EMAIL' => ['regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/']
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function addNewSubscriber(){
            $validatedData = $this->validate();

            // Create postData object and convert user profile json string to json object
            $postData = [];
            foreach ($validatedData as $key => $value) {
                if($key === "STATUS"){
                    //status value convert to int
                    $postData[$key] = intval($value);
                }else{
                    $postData[$key] = $value;
                }
            }

            $package = PackageModel::where('PKGID', $postData['PACKAGEID'])
                                ->where('GROUPID', $this->brand)
                                ->first();

            if($package){

                $location = LocationModel::where('LOCID', $postData['LOCID'])
                                        ->where('GROUPID', $this->brand)
                                        ->first();

                if($location){
                    $record = SubscriberModel::where('USERID', $postData['USERID'])->first();
                    if ($record) {
                        session()->flash('message','Device already exists');
                        session()->flash('status', 'danger');
                        $this->dispatchBrowserEvent('close-modal');
                        $this->dispatchBrowserEvent('close-alert');
                    } else {
                        // Add additional fields
                        $postData['GROUPID'] = $this->brand;
                        $postData['VOLUMEQTA'] = $package->VOLQUOTA;
                        $postData['TIMEQTA'] = $package->TIMEQUOTA;
                        $postData['EXPDATE'] = $this->getExpireDate((int) $package->TIMEQUOTA);
                        $postData['MACPLANE'] = $this->getPlaneMacAddress($postData['MAC']);
                        $postData['FIRSTLOGIN'] = null;
                        $postData['LASTLOGIN'] = null;
                        $postData['DEVICE_NAME'] = null;
                        $postData['MASTER_USER'] = null;
                        $postData['RECHARGEKEY'] = '';
                        $postData['KICK_OUT'] = 0;
                        $postData['VLAN'] = $this->getVlanFromAccessGroup($postData['LOCID']);
                        $postData['CREATEDATE'] = Carbon::now()->format('Y-m-d H:i:s');

                        SubscriberModel::create($postData);
                        session()->flash('message','Device account created successfully');
                        session()->flash('status', 'success');
                        $this->resetInput();
                        $this->dispatchBrowserEvent('close-modal');
                        $this->dispatchBrowserEvent('close-alert');
                        $this->getSubscribers();
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

    public function getVlanFromAccessGroup($accGroup)
    {
        // Extract the type from the 13th character (index 12)
        $type = substr($accGroup, 12, 1);

        // Extract the ID from the 14th character (index 13) and adjust it by subtracting 1
        $id = intval(substr($accGroup, 13, 1)) - 1;

        if ($type === 'G' && !is_nan($id)) {
            return '10' . $id;
        }
        if ($type === 'P' && !is_nan($id)) {
            return '20' . $id;
        }
        if ($type === 'R' && !is_nan($id)) {
            return '100' . $id;
        }

        return null;
    }

    public function getPlaneMacAddress($macAddress)
    {
        // Remove dashes and colons from the MAC address
        $macPlane = str_replace(['-', ':'], '', $macAddress);
        return $macPlane;
    }

    public function editSubscriber($REFID){
        $this->refId = $REFID;
        $subscriber = array_filter($this->subscriberArray, function ($subscriber) use ($REFID){
            return $subscriber["REFID"] === $REFID;
        });
        $arrayVales = array_values($subscriber);
        $data = $arrayVales[0];

        if($subscriber){
            $this->USERID = $data['USERID'];
            $this->PASSWORD = $data['PASSWORD'];
            $this->PACKAGEID = $data['PACKAGEID'];
            $this->STATUS = $data['STATUS'];
            $this->MAC = $data['MAC'];
            $this->LOCID = $data['LOCID'];
            $this->DEPARTMENT = $data['DEPARTMENT'];
            $this->TOKEN_REF = $data['TOKEN_REF'];
            $this->FIRST_NAME = $data['FIRST_NAME'];
            $this->LAST_NAME = $data['LAST_NAME'];
            $this->PHONE = $data['PHONE'];
            $this->EMAIL = $data['EMAIL'];
            $this->USERPROFILE = json_encode($data['USERPROFILE']);
        }else{
            return redirect()->to('/devices');
        }
    }

    public function updateSubscriber(){
        $validatedData = $this->validate();

        //Create postData object and convert locationMatchEntry json string to json object
        $postData = [];
        foreach ($validatedData as $key => $value) {
            if($key === "STATUS"){
                //status value convert to int
                $postData[$key] = intval($value);
            }else{
                $postData[$key] = $value;
            }
        }

        $package = PackageModel::where('PKGID', $postData['PACKAGEID'])
                            ->where('GROUPID', $this->brand)
                            ->first();

        if($package){

            $location = LocationModel::where('LOCID', $postData['LOCID'])
                                    ->where('GROUPID', $this->brand)
                                    ->first();

            if($location){
                $record = SubscriberModel::where('REFID', $this->refId)->first();
                if ($record) {
                    // Add additional fields
                    $postData['GROUPID'] = $this->brand;
                    $postData['VOLUMEQTA'] = $package->VOLQUOTA;
                    $postData['TIMEQTA'] = $package->TIMEQUOTA;
                    $postData['EXPDATE'] = $this->getExpireDate((int) $package->TIMEQUOTA);
                    $postData['MACPLANE'] = $this->getPlaneMacAddress($postData['MAC']);

                    // Update the existing record
                    $record->update($postData);
                    session()->flash('message','Device account updated successfully');
                    session()->flash('status', 'success');
                    $this->resetInput();
                    $this->dispatchBrowserEvent('close-modal');
                    $this->dispatchBrowserEvent('close-alert');
                    $this->getSubscribers();
                } else {
                    session()->flash('message','Device account not found');
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

        }else{
            $errorMsg = 'Invalid package ID';
            session()->flash('message',$errorMsg);
            session()->flash('status', 'danger');
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('close-alert');
        }
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
        $this->MAC= '';
        $this->FIRST_NAME= '';
        $this->LAST_NAME= '';
        $this->PHONE= '';
        $this->EMAIL= '';
        $this->TOKEN_REF= '';
        $this->USERPROFILE= '';
        $this->DEPARTMENT ='';
    }

    public function deleteSubscriber($REFID){
        $this->deleteSubscriberId = $REFID;
    }

    public function destroySubscriber(){
        $record = SubscriberModel::find($this->deleteSubscriberId);

        if ($record) {
            $record->delete();
            session()->flash('message','Subscriber Deleted Successfully');
            session()->flash('status', 'success');
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('close-alert');
            $this->getSubscribers();
        } else {
            session()->flash('message', 'Subscriber not found' );
            session()->flash('status', 'danger');
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('close-alert');
        }

    }

    public function mount(){
        $this->searchTerm = '';
        $this->brand = session('brand');
        $this->getSubscribers();
    }

    public function getSubscribers(){
        // Retrieve data from the database and convert to an array of objects
        $this->subscriberData = SubscriberModel::select(
            'USERID',
            'PASSWORD',
            'GROUPID',
            'VOLUMEQTA',
            'TIMEQTA',
            'PACKAGEID',
            'STATUS',
            'CREATEDATE',
            'DEPARTMENT',
            'EXPDATE',
            'LOCID',
            'MAC',
            'REFID',
            'PHONE',
            'FIRSTLOGIN',
            'FIRST_NAME',
            'LAST_NAME',
            'EMAIL',
            'USERPROFILE',
            'TOKEN_REF'
        )->where('GROUPID', $this->brand)
        ->latest('CREATEDATE')
        ->get()
        ->map(function ($item) {
            return (object) $item->toArray();
        })->toArray();

    }

    public function render()
    {

        //Unset USERPROFILE object from the data
        // for($i=0; $i <= count((array)$this->subscriberData)-1; $i++){
        //     if (isset($this->subscriberData[$i]->USERPROFILE)) {
        //         unset($this->subscriberData[$i]->USERPROFILE);
        //     }
        // }

        $this->subscriberArray = $this->subscriberData;
        if(!$this->subscriberArray){
            $this->subscriberArray = [];
        }
        // dump($this->subscriberArray);
        // dump($this->subscriberArray);
        //If user search some string, this code block triggers
        $searchTerm = $this->searchTerm;
        if($searchTerm !== '' || $searchTerm !== null){

            $results = array_filter($this->subscriberArray, function ($obj) use ($searchTerm) {
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
            $this->subscriberArray = $results;
        }
        // dump($this->subscriberArray);
        //Data rendering to the blade with pagination
        $perPage = 10;
        $this->page = request("page") ?? $this->page;
        $rawCollection = $this->subscriberArray;
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
        $paginator = new LengthAwarePaginator($items, $fixedCollection->count(), $perPage, $this->page, ['path' => url('devices')]);
        return view('livewire.subscriber', ['subscribers' => $paginator]);

    }

}
