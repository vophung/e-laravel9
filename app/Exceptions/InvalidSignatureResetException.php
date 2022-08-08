<?php

namespace App\Exceptions;

use Exception;

class InvalidSignatureResetException extends Exception
{

    /**
    * Create a new exception instance.
    *
    * @return void
    */

    public function __construct()
    {

    }

    public function render() 
    {
        return view('expired-reset');
    }
}
