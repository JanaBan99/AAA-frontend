<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SetUserTimezone
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $timezone = Auth::user()->TIMEZONE; // Assume user model has a timezone attribute
            dump($timezone);
            if ($timezone) {
                // Set the timezone for Carbon
                config(['app.timezone' => $timezone]);
                Carbon::setLocale($timezone);
            }
        }

        return $next($request);
    }
}
