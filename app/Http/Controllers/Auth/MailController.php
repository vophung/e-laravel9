<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RegisterMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public static function sendRegisterMail($name, $email, $verification_code)
    {
        $data = ['name' => $name, 'verification_code' => $verification_code];

        Mail::to($email)->send(new RegisterMail($data));
    }
}
