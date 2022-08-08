<?php

namespace App\Http\Requests\Auth;

use App\Events\Registered;
use App\Jobs\SendMailJob;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|min:8|max:25|regex:/[\sA-Za-z0-9\p{L}]$/',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|required_with:confirm_password|same:confirm_password|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter your name',
            'name.min' => 'Please enter more than 8 characters',
            'name.max' => 'Please enter less than 25 characters',
            'name.regex' => 'Please enter a valid name',
            'email.required' => 'Please enter your email',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'Emeail already exists',
            'email.max' => 'Please enter less than 255 characters',
            'password.required' => 'Please enter your password',
            'password.confirmed' => 'Please enter confirm password',
            'password.min' => 'Please enter more than 8 characters',
            'password.regex' => 'Please enter a password with 0 to 9, upper and lower case characters',
            'password.required_with' => 'Please enter confirm password',
            'password.same' => 'Password does not match',   
        ];
    }

    public function withValidator($validator)
    {
        if(!$validator->fails()){
            $validator->after(function($validator) {
                DB::beginTransaction();

                try {
                    $user = new User();
                    $user->name = $this->name;
                    $user->email = $this->email;
                    $user->password = bcrypt($this->password);
                    $user->verification_code = sha1(time());
                    $user->save();
                                   
                    $data = ['name'  => $user->name, 'email' => $user->email, 'verification_code' => $user->verification_code];

                    DB::commit();
                    
                    event(new Registered($data));
                }catch (Exception $e){
                    DB::rollback();

                    return view('404');
                }
            });
        }
    }
}
