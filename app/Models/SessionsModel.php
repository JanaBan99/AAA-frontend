<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionsModel extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table  = 'ADMIN_SESSIONS';

    // Optionally, specify the primary key if it's not 'id'
    protected $primaryKey = 'REFID';

    // If the primary key is not an auto-incrementing integer, specify its type
    protected $keyType = 'int';

    // Disable timestamps management
    public $timestamps = false;

    // Specify the columns that can be mass-assigned
    protected $fillable = [
        'REFID', 'USERID', 'SESSIONID', 'IP_ADDRESS', 'CREATEDATE', 'LASTUPDATE'
    ];
}
