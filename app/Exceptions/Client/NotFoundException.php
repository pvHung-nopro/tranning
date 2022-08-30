<?php

namespace App\Exceptions\Client;

use Exception;
use App\Exceptions\Client\ClientException;

class NotFoundException extends ClientException
{
    protected $code = 404; 
}