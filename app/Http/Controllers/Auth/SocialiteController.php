<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class SocialiteController extends Controller
{
    /**
    * API google redirect.
    *
    * @return \Illuminate\Http\Response
    */
    public function redirect_google() {
        return Socialite::driver('google')->redirect();
    }

    /**
    * API google callback.
    *
    * @return \Illuminate\Http\Response
    */
    public function callback_google() {
        $data = Socialite::driver('google')->user();

        $validatedUser = User::where('google_id', $data->id);

        if($validatedUser->exists()) { return User::loginWithGoogle($validatedUser->first());
        }else { return $this->_registerAsGoogleUser($data); }
    }

    /**
    * API facebook redirect.
    *
    * @return \Illuminate\Http\Response
    */
    public function redirect_facebook() {
        return Socialite::driver('facebook')->redirect();
    }

    /**
    * API facebook callback.
    *
    * @return \Illuminate\Http\Response
    */
    public function callback_facebook() {
        $data = Socialite::driver('facebook')->user();

        $validatedUser = User::where('facebook_id', $data->id);

        if($validatedUser->exists()) { return User::loginWithFacebook($validatedUser->first());
        }else { return $this->_registerAsFacebookUser($data); }
    }

    /**
     * Store a newly created resource in storage and login user as google.
     *
     * @param  data
     * @return auth/login
     */
    protected function _registerAsGoogleUser($data) {
        try {
            $user = new User();
            $user->name = $data->name;
            $user->google_id = $data->id;
            $user->is_verified = 1;
            $user->save();
    
            DB::commit();
    
            $validatedUser = User::where('google_id', $user->google_id);
    
            return User::loginWithGoogle($validatedUser->first());
        }catch (Exception $e) {
            DB::rollback();

            return view('404');
        }
    }

    /**
     * Store a newly created resource in storage and login user as facebook.
     *
     * @param  data
     * @return auth/login
     */
    protected function _registerAsFacebookUser($data) {
        try {
            $user = new User();
            $user->name = $data->name;
            $user->facebook_id = $data->id;
            $user->is_verified = 1;
            $user->save();

            DB::commit();

            $validatedUser = User::where('facebook_id', $user->facebook_id);
    
            return User::loginWithFacebook($validatedUser->first());
        }catch (Exception $e) {
            DB::rollback();

            return view('404');
        }
    }
}
