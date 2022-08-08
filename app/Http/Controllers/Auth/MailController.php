<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RegisterMail;
use App\Mail\ResetPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public static function sendRegisterMail($name, $email, $verification_code, $url)
    {
        $data = ['name' => $name, 'verification_code' => $verification_code, 'url' => $url];

        Mail::to($email)->send(new RegisterMail($data));
    }

    public static function sendResetPasswordMail($email, $token, $url) 
    {
        $data = ['email' => $email, 'token' => $token, 'url' => $url];

        Mail::to($email)->send(new ResetPasswordMail($data));
    }
}
