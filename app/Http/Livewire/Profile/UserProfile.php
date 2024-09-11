<?php

namespace App\Http\Livewire\Profile;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Helpers\HashHelper;

class UserProfile extends Component
{
    public $user;
    public $USERNAME;
    public $userNameTop;
    public $lastUpdate;
    public $createDate;
    public $REFID;
    public $NEW_PASSWORD;
    public $CONFIRM_PASSWORD;
    public $EMAIL;
    public $groupId;
    public $accessModules;
    public $IS_ENABLE;
    public $createUser;
    public $showPassword = false;
    public $brand;

    protected $messages = [
        'USERNAME.string' => 'The username should be a string',
        'USERNAME.max' => 'The username must be shorter than or equal to 20 characters',
        'USERNAME.regex' => 'The username may only contain letters, numbers, and underscores',
        'PHONE.regex' => 'The phone number must be a valid 10-digit phone number (ex:- xxx-xxx-xxxx)',
        'NEW_PASSWORD.required' => 'The new password field is required',
        'NEW_PASSWORD.min' => 'The password must be at least 8 characters',
        'NEW_PASSWORD.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character',
        'CONFIRM_PASSWORD.required' => 'The confirm password field is required',
        'CONFIRM_PASSWORD.same' => 'The password confirmation does not match',
        'EMAIL.regex' => 'Invalid email address'
    ];

    protected function rules(){
        return [
            'REFID' => ['required'],
            'USERNAME' => ['required', 'string', 'regex:/^[\w]+$/', 'max:20'],
            'NEW_PASSWORD' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@;$!%*?&#]/',
            ],
            'CONFIRM_PASSWORD' => ['required', 'same:NEW_PASSWORD'],
            'EMAIL' => ['required', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
            'PHONE' => ['required', 'regex:/^\d{3}-\d{3}-\d{4}$/'],
            'IS_ENABLE' => ['required', 'integer', 'in:0,1'],
        ];
    }

    public function togglePassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function mount() {
        $this->brand = session('brand');
        $this->getAuthUser();
    }

    public function updated($propertyName){

        $this->validateOnly($propertyName);
    }

    public function updateProfile()
    {
        $validatedData = $this->validate([
            'REFID' =>'',
            'USERNAME' => ['required', 'string', 'regex:/^[\w]+$/', 'max:20'],
            'EMAIL' => ['required', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
            'PHONE' => ['required', 'regex:/^\d{3}-\d{3}-\d{4}$/'],
            'IS_ENABLE' => ['required', 'integer', 'in:0,1'],
        ]);

        // Create postData associative array
        $postData = [];
        foreach ($validatedData as $key => $value) {
            if($key === "IS_ENABLE"){
                //status value convert to int
                $postData[$key] = intval($value);
            }else{
                $postData[$key] = $value;
            }
        }

        try {
            $record = User::where('REFID', $postData['REFID'])
                                ->where('GROUPID', $this->brand)
                                ->first();
            if($record){
                $postData['LASTUPDATE'] = Carbon::now()->format('Y-m-d H:i:s');

                // Update the existing record
                $record->update($postData);
                session()->flash('message','User profile updated successfully');
                session()->flash('status', 'success');
                $this->getAuthUser();
                $this->dispatchBrowserEvent('close-alert');

            }else{
                session()->flash('message','User profile not found');
                session()->flash('status', 'danger');
                $this->dispatchBrowserEvent('close-modal');
                $this->dispatchBrowserEvent('close-alert');
            }
        } catch (\Throwable $th) {
            dd($th);
        }

    }

    public function updatePassword()
    {
        $validatedData = $this->validate([
            'REFID' =>'',
            'NEW_PASSWORD' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@;$!%*?&#]/',
            ],
            'CONFIRM_PASSWORD' => 'required|same:NEW_PASSWORD',
        ]);

        // Create postData associative array
        $postData = [];
        foreach ($validatedData as $key => $value) {
            if($key === "NEW_PASSWORD"){
                //Hash the password using sha-512 hash function
                $postData['PASSWORD'] = HashHelper::sha512($value);
            }else if($key === "REFID"){
                $postData[$key] = $value;
            }
        }

        try {
            $record = User::where('REFID', $postData['REFID'])
                                ->where('GROUPID', $this->brand)
                                ->first();
            if($record){
                $postData['LASTUPDATE'] = Carbon::now()->format('Y-m-d H:i:s');

                // Update the existing record
                $record->update($postData);
                session()->flash('message','User password changed successfully');
                session()->flash('status', 'success');
                $this->resetInput();
                $this->getAuthUser();
                $this->dispatchBrowserEvent('close-alert');

            }else{
                session()->flash('message','User profile not found');
                session()->flash('status', 'danger');
                $this->dispatchBrowserEvent('close-modal');
                $this->dispatchBrowserEvent('close-alert');
            }
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function resetInput(){
        $this->NEW_PASSWORD = "";
        $this->CONFIRM_PASSWORD = "";
    }

    public function getAuthUser(){
        $this->user = auth()->user();
    }

    public static function sha512($data)
    {
        return hash('sha512', $data);
    }

    public function render()
    {
        $this->REFID = $this->user->REFID;
        $this->USERNAME = $this->user->USERNAME;
        $this->userNameTop = $this->user->FULLNAME;
        $this->EMAIL = $this->user->EMAIL;
        $this->IS_ENABLE = $this->user->IS_ENABLE;
        $this->PHONE = $this->user->PHONE;
        $this->createDate = $this->user->CREATE_DATE;
        $this->lastUpdate = $this->user->LASTUPDATE;

        return view('livewire.profile.user-profile');
    }

}
