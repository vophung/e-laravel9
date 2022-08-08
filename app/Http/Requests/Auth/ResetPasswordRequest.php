<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use App\Rules\TokenRule;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'password' => 'required|required_with:confirm_password|same:confirm_password|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
            'token' => ['required', new TokenRule()]
        ];
    }


    /**
     * Get the messages that apply to the rules.
     *
     * @return array<string, mixed>
     */

    public function messages()
    {
        return [
            'email.required' => 'Please enter your email.',
            'email.email' => 'Invalid Email',
            'email.exists' => 'Email already exists',
            'password.required' => 'Please enter your password',
            'password.confirmed' => 'Please enter your confirm password',
            'password.min' => 'Password contains at least 8 characters',
            'password.regex' => 'Password contains at least 8 characters, 1 uppercase, 1 lowercase, and number',
            'password.required_with' => 'Please enter password again',
            'password.same' => 'Password does not match',
            'token.required' => 'Missing token your email' 
        ];
    }

    public function withValidator($validator)
    {
        if(!$validator->fails()){
            $validator->after(function ($validator) {

                DB::beginTransaction();

                try {

                    $tokenData = DB::table('password_resets')->where('token', $this->token)->first();

                    $user = User::where('email', $tokenData->email)->first();

                    $user->password = Hash::make($this->password);
                    
                    $user->update();

                    DB::table('password_resets')->where('email', $user->email)->delete();

                    DB::commit();
                }catch (Exception $e){
                    DB::rollback();

                    return view('404');
                }
                
            });
        }
    }
}
