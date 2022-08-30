<?php

namespace App\Exceptions\Server;

use Exception;

class SystemException extends Exception
{
    protected $code = 500; // INTERNAL SERVER ERROR
}