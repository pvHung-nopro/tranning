<?php

namespace App\Exceptions\Client;

use Exception;

class ClientException extends Exception
{
    protected $code = 400; // INTERNAL SERVER ERROR
}