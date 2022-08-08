<?php

namespace App\Http\Controllers\Auth;

use App\Events\Registered;
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

    public function verifyAccount(Request $request, $code) {
        $verification_code = $code;
        $user = User::where(['verification_code' => $verification_code])->select('id','is_verified','email_verified_at')->first();
        
        if($user->is_verified == 1) return redirect()->route('login.index')->with('warning', 'You have verified your account');
        
        if($user != null) {
            $user->is_verified = 1;
            $user->email_verified_at = Carbon::now();
            $user->save();
            
            return redirect()->route('login.index')->with('success', 'Your account has been verified');
        }

        return redirect()->route('login.index')->with('error', 'Seomthing went wrong');
    }

    public function resendEmail($code) {
        $user = User::where(['verification_code' => $code])->select('name','email','verification_code')->first();
        
        $data = ['name'  => $user->name, 'email' => $user->email, 'verification_code' => $user->verification_code];

        event(new Registered($data));

        return view('mail.successfull')->with('data', [
            'name' => $user->name,
            'email' => $user->email
        ]);
    }

    public function checkEmail(Request $request) {
        $email = $request->input('email');

        $isExists = User::where('email', $email)->first();

        if($isExists) {
            return response()->json(array("exists" => true));
        }else {
            return response()->json(array("exists" => false));
        }
    }
}
