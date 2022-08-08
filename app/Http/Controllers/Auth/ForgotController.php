<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Http\Request;

class ForgotController extends Controller
{
    use CanResetPassword;
    
    /**
    * Display a listing of the resource..
    *
    * @return \Illuminate\Http\Response
    */
    public function index() {
        return view('auth.forgot-password.index');
    }

    /**
    * Display a listing of the resource..
    *
    * @return \Illuminate\Http\Response
    */
    public function reset($token, $email) {
        $data = ['email' => $email, 'token' => $token];

        return view('auth.reset-password.index')->with('data', $data);
    }

    /**
    * Display a listing of the resource..
    *
    * @return \Illuminate\Http\Response
    */
    public function email(ForgotPasswordRequest $request) {
        return redirect()->back()->with('success', 'A reset link has been sent to your email address.');
    }

    /**
    * Update the specified resource in storage
    *
    * @return \Illuminate\Http\Response
    */
    public function update(ResetPasswordRequest $request) {
        $data = ['email' => $request->email, 'password' => $request->password];

        return User::loginWithAccount($data);
    }
}
