<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table  = 'ADMIN_USERS';

    // Optionally, specify the primary key if it's not 'id'
    protected $primaryKey = 'REFID';

    // If the primary key is not an auto-incrementing integer, specify its type
    protected $keyType = 'int';

    // Disable timestamps management
    public $timestamps = false;

    // Specify the columns that can be mass-assigned
    protected $fillable = [
        'REFID', 'USERNAME', 'PASSWORD', 'EMAIL', 'FULLNAME', 'PHONE',
        'ACCESS_ROLE', 'IS_ENABLE', 'GROUPID', 'CREATE_DATE', 'LASTUPDATE',
        'LOCKOUT_THRESHOLD', 'LOCKOUT_DURATION', 'LOCKED_STATUS', 'DISABLED_STATUS',
        'TIMEZONE', 'ONLINE_STATUS', 'LAST_LOGIN', 'DORMANT_THRESHOLD_IN_DAYS'
    ];
}
