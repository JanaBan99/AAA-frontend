<?php

use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Logout;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\ResetPassword;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\ChatHistory;
// use App\Http\Livewire\Package;
// use App\Http\Livewire\Subscriber;
// use App\Http\Livewire\Master;
// use App\Http\Livewire\Profile\UserProfile;
// use App\Http\Livewire\Notifications;
// use App\Http\Livewire\AAALogs;
// use App\Http\Livewire\RadiusLogs;
use GuzzleHttp\Middleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
    return redirect('sign-in');
});

Route::middleware(['branding','XSS'])->group(function () {
    Route::get('sign-in', Login::class)->middleware('guest')->name('login');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');
    Route::get('chat-history', ChatHistory::class)->name('chat-history');
    // Route::get('knowledge-base-creation', Package::class)->name('knowledgeBaseCreation');
});
