<?php

namespace App\Http\Livewire\Auth;
use Livewire\Component;
use App\Models\SessionsModel;

class Logout extends Component
{
    protected $listeners = ['logout' => 'logout', 'sessionTimedOut' => 'sessionTimedOut']; // Listen for these events

    public function logout()
    {
        try {
            $user = auth()->user();

            auth()->logout();

            // Invalidate the session and regenerate the token
            session()->invalidate();
            session()->regenerateToken();

            //Delete current session
            $currentSession = SessionsModel::where('USERID', $user->REFID)->first();
            if($currentSession){
                $currentSession->delete();
            }

            return redirect('/sign-in');
        } catch (\Throwable $th) {
            dd($th);
        }

    }

    public function sessionTimedOut()
    {
        $user = auth()->user();

        auth()->logout();

        // Invalidate the session and regenerate the token
        session()->invalidate();
        session()->regenerateToken();

        //Delete current session
        $currentSession = SessionsModel::where('USERID', $user->REFID)->first();
        if($currentSession){
            $currentSession->delete();
        }

        session()->flash('error-status','Session has expired. Please log in again.');
        return redirect('/sign-in');

    }

    public function render()
    {
        return view('livewire.auth.logout');
    }
}
