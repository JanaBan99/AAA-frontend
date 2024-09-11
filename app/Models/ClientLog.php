<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientLog extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table  = 'CLIENTLOG';

    // Optionally, specify the primary key if it's not 'id'
    protected $primaryKey = 'ID';

    // If the primary key is not an auto-incrementing integer, specify its type
    protected $keyType = 'int';

    // Specify the columns that can be mass-assigned
    protected $fillable = [
        'USERID', 'SESSIONID', 'MULTI_SESSION_ID', 'NASID', 'EVENTTIME', 'GMT',
        'CLIENTIP', 'MAC', 'CALLEDSTATIONID', 'WISPRLOCID', 'SERVICE_TYPE',
        'MESSAGE', 'INFOTYPE', 'TOKENID', 'USER_TERMINATE_REASON'
    ];
}
