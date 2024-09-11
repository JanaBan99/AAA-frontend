<?php

namespace App\Helpers;

class HashHelper
{
    public static function sha512($data)
    {
        return hash('sha512', $data);
    }
}
