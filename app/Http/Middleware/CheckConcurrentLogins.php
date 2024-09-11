<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\SessionsModel;
use Illuminate\Http\Request;

class CheckConcurrentLogins
{
    public function handle(Request $request, Closure $next)
    {
        try {
            if (Auth::check()) {
                $user = Auth::user();
                $currentSessionId = Session::getId();

                // Check for active sessions
                $activeSessions = SessionsModel::where('USERID', $user->REFID)
                    ->where('SESSIONID', '!=', $currentSessionId)
                    ->exists();

                if ($activeSessions) {
                    // Handle concurrent session
                    Auth::logout();
                    session()->flash('error-status','Your account is logged in from another location');
                    return redirect('/sign-in');
                }

                // Update or create session in the database
                SessionsModel::updateOrCreate(
                    ['USERID' => $user->REFID],
                    [
                        'SESSIONID' => $currentSessionId,
                        'IP_ADDRESS' => $request->ip()
                    ]
                );
            }

            return $next($request);

        } catch (\Throwable $th) {
            dd($th);
        }


    }
}

