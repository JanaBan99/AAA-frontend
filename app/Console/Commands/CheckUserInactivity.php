<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CheckUserInactivity extends Command
{
    protected $signature = 'user:check-inactivity';
    protected $description = 'Check and update user inactivity based on last login and dormant threshold';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get current date and time
        $now = Carbon::now();

        // Fetch all users
        $users = DB::table('ADMIN_USERS')->get();

        foreach ($users as $user) {
            // Check if the user should be considered inactive
            $lastLogin = Carbon::parse($user->LAST_LOGIN);
            $dormantThreshold = (int) $user->DORMANT_THRESHOLD_IN_DAYS;
            $expirationTime = $lastLogin->addDays($dormantThreshold);

            if ($now->greaterThanOrEqualTo($expirationTime) && $user->IS_ENABLE == 1) {
                // Update IS_ENABLE to 0 for inactive users
                DB::table('ADMIN_USERS')
                    ->where('REFID', $user->REFID)
                    ->update(['IS_ENABLE' => 0]);

                // dump("User ID {$user->id} has been marked as inactive.");
            }
        }

        // dump('User inactivity check completed.');
    }
}
