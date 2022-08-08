<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    public function __construct() {
        $this->middleware('checkLogged')->only(['index','signin']);
    }

    public function index() {
        return view('auth.login.index');
    }

    public function signin(LoginRequest $request) {
        $data = ['email' => $request->email, 'password' => $request->password];

        if($request->has('rememberme')){ Cookie::queue('email', $request->email, 1440); Cookie::queue('password', $request->password, 1440);
        }else { Cookie::queue(Cookie::forget('email')); Cookie::queue(Cookie::forget('password'));}

        return User::loginWithAccount($data);
    }

    public function logout() {
        try { Auth::logout(); return redirect()->route('login.index'); }
        catch (Exception $e) { return view('404'); }
    }
}
