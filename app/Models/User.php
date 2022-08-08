<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use League\OAuth1\Client\Credentials\Credentials;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $incrementing = false; 
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verification_code',
        'is_verified',
        'google_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function loginWithAccount($data) {
        $user = User::where('email', $data['email'])->select('is_verified')->first();

        $credentials = ['email' => $data['email'], 'password' => $data['password'], 'is_verified' => 1];

        if(!$user) {
            return redirect()->route('login.index')->with('error', 'Account does not exist');
        }else {
            if(Auth::attempt($credentials)){
                return redirect()->route('homepage');
            }else if($user->is_verified != 1){
                return redirect()->route('login.index')->with('error', 'Your account is not verified');
            }
        }
    }

    public static function loginWithGoogle($data){
        if(Auth::loginUsingId($data->id)){ return redirect()->route('homepage');
        }else { return redirect()->route('login.index')->with('error', 'Something went wrong'); }
    }

    public static function loginWithFacebook($data){
        if(Auth::loginUsingId($data->id)){ return redirect()->route('homepage');
        }else { return redirect()->route('login.index')->with('error', 'Something went wrong'); }
    }
}
