<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Carbon;

class RegisterController extends Controller
{
    public function index() {
        return view('auth.register.index');
    }

    public function store(RegisterRequest $request) {
        $data = ['name'  => $request->name, 'email' => $request->email];

        return view('mail.successfull')->with('data', $data);
    }

    public function verifyAccount(Request $request) {
        $verification_code = $request->get('code');
        $user = User::where(['verification_code' => $verification_code])->first();
        
        if($user != null) {
            $user->is_verified = 1;
            $user->email_verified_at = Carbon::now();
            $user->save();

            return redirect()->route('login.index')->with(session()->flash('alert-success', 'Your account has been verified'));
        }

        return redirect()->route('login.index')->with(session()->flash('alert-danger', 'Something went wrong'));
    }
}
