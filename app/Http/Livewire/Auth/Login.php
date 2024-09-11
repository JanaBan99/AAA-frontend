<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LoginAttemptsModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helpers\HashHelper;
use stdClass;
use Carbon\Carbon;

class Login extends Component
{

    public $username='';
    public $password='';
    public $group_id='';
    public $isLoading = false;
    public $showPassword = false;
    public $appVersion = '';
    public $remainingAttempts;
    public $remainingTime;

    protected $rules= [
        'username' => 'required',
        'password' => 'required'
    ];

    public function render()
    {
        return view('livewire.auth.login');
    }

    public function mount() {
        $this->brand = session('brand');
        $this->appVersion = config('app.version');
    }

    public function togglePassword()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function login(Request $request)
    {
        $attributes = $this->validate();
        $postData = new stdClass();
        foreach ($attributes as $key => $value) {
            $postData->$key = $value;
        }

        try {
            $user = User::where('USERNAME', $postData->username)->first();

            if ($user) {
                if($user->IS_ENABLE === 1){
                    if($user->LOCKED_STATUS === 0){
                        if($user->GROUPID === $this->brand){
                            if($this->checkPassword($postData->password, $user->PASSWORD)){

                                //When the user enters correct credentials, attempts count should be reset to 0
                                $attempt = LoginAttemptsModel::where('USER_REF', $user->REFID)->first();
                                if($attempt && $attempt->ATTEMPTS_COUNT > 0){
                                    $attemptsData['ATTEMPTS_COUNT'] = 0;
                                    $attempt->update($attemptsData);
                                }

                                //Update last login time
                                $adminUserData['LAST_LOGIN'] = Carbon::now($user->TIMEZONE)->format('Y-m-d H:i:s');
                                $user->update($adminUserData);

                                auth()->login($user);
                                session()->regenerate();
                                return redirect('dashboard');

                            }else{

                                //Create login attempts record when user enter an invalid password
                                $attempt = LoginAttemptsModel::where('USER_REF', $user->REFID)->first();
                                if($attempt){
                                    //Check the lockout shreshold is exceeded the attepts counts
                                    if($user->LOCKOUT_THRESHOLD >= $attempt->ATTEMPTS_COUNT+1){
                                        $attemptsData['IP'] = $request->ip();
                                        $attemptsData['ATTEMPTS_COUNT'] = $attempt->ATTEMPTS_COUNT + 1;
                                        $attempt->update($attemptsData);
                                        session()->flash('error-status','Provided credentials could not be verified');
                                        $this->dispatchBrowserEvent('close-alert');
                                        //Remainning attempts
                                        $this->remainingAttempts = $user->LOCKOUT_THRESHOLD - $attempt->ATTEMPTS_COUNT;
                                    }else{
                                        $adminUserData['LOCKED_STATUS'] = 1;
                                        $user->update($adminUserData);

                                        $this->remainingTime = $this->calculateRemainingTime($user->LASTUPDATE, $user->LOCKOUT_DURATION, $user->TIMEZONE);
                                        session()->flash('error-status','This account is locked. Please try again in ' . $this->remainingTime . ' seconds.');
                                        $attemptsData['ATTEMPTS_COUNT'] = 0;
                                        $attempt->update($attemptsData);
                                    }
                                }else{
                                    session()->flash('error-status','System error');
                                    $this->dispatchBrowserEvent('close-alert');
                                }

                            }
                        }else{
                            session()->flash('error-status','Provided credentials could not be verified');
                            $this->dispatchBrowserEvent('close-alert');
                        }
                    }else{
                        $this->remainingTime = $this->calculateRemainingTime($user->LASTUPDATE, $user->LOCKOUT_DURATION, $user->TIMEZONE);
                        if($this->remainingTime === 0 ){
                            $adminUserData['LOCKED_STATUS'] = 0;
                            $user->update($adminUserData);
                            session()->flash('success-status','This account is unlocked. Please login again');
                        }else{
                            session()->flash('error-status','This account is locked. Please try again in ' . $this->remainingTime. ' seconds' );
                        }

                    }
                }else{
                    session()->flash('error-status','This account is disabled');
                }

            }else{
                session()->flash('error-status','Provided credentials could not be verified');
                $this->dispatchBrowserEvent('close-alert');
            }
        } catch (\Throwable $th) {
            dd($th);
        }


    }

    public function calculateRemainingTime($lockoutTime, $lockoutDuration, $timezone)
    {
        $lockoutDurationInSeconds = $lockoutDuration * 60 ;
        // Ensure $lockoutUntil is a Carbon instance
        $lockoutTimestamp = Carbon::createFromFormat('Y-m-d H:i:s', $lockoutTime, $timezone)->timestamp;
        $currentTimetamp = Carbon::now($timezone)->timestamp;
        $unlockTimestamp = $lockoutTimestamp + $lockoutDurationInSeconds;
        if($unlockTimestamp > $currentTimetamp ){
            return $unlockTimestamp - $currentTimetamp;
        }else{
            return 0;
        }

    }

    private function checkPassword($plainPassword, $hashedPassword)
    {
        return HashHelper::sha512($plainPassword) === $hashedPassword;
    }


}
