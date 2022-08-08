<?php

namespace App\Exceptions;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class InvalidSignatureException extends Exception
{
    public $code;

     /**
     * Create a new exception instance.
     *
     * @return void
     */

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function render(Request $request) 
    {
        $code = $this->code;
        
        return view('expired-sendmail')->with('code', $code);
    }
}
