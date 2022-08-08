<?php

namespace App\Http\Requests\Auth;

use App\Jobs\ForgotPasswordJob;
use App\Rules\CheckGoogleAccountRule;
use App\Rules\EmailRule;
use App\Rules\VerifiedRule;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ForgotPasswordRequest extends FormRequest
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
            'email' => ['required', 'email', 'max:255', new EmailRule(), new VerifiedRule(), new CheckGoogleAccountRule()]
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Please enter your email',
            'email.email' => 'Email is not valid',
            'email.max' => 'Maximun character is 255'
        ];
    }

    public function withValidator($validator)
    {
        if(!$validator->fails()){
            $validator->after(function ($validator) {
                
                DB::beginTransaction();
            
                try {

                    DB::table('password_resets')->insert([
                        'email' => $this->email,
                        'token' => Str::random(60),
                        'created_at' => Carbon::now()
                    ]);

                    DB::commit();
    
                    $tokenData = DB::table('password_resets')->where('email', $this->email)->latest()->first();
    
                    $url = URL::temporarySignedRoute('password.reset', now()->addMinutes(15), [
                        'token' => $tokenData->token,
                        'email' => $tokenData->email
                    ]);

                    ForgotPasswordJob::dispatch(['email' => $this->email, 'token' => $tokenData->token, 'url' => $url]);

                }catch (Exception $e) {
                    DB::rollback();

                    return view('404');
                }
            });
        }
    }
}
