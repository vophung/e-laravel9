<?php

use App\Http\Controllers\Auth\ForgotController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(LoginController::class)->name('login.')->group(function() {
    Route::get('/login', 'index')->name('index');
    Route::post('/login', 'signin')->name('signin');
    Route::post('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->name('register.')->group(function() {
    Route::get('/register', 'index')->name('index');
    Route::get('/resend-mail/{code}', 'resendEmail')->name('resend-email');
    Route::post('/register', 'store')->name('store');
    Route::post('/check-email', [RegisterController::class, 'checkEmail'])->name('check-email');
});

Route::controller(ForgotController::class)->name('password.')->group(function() {
    Route::get('/forgot-password','index')->name('index');
    Route::any('/password/reset/{token}/email={email}','reset')->name('reset')->middleware('expries-reset');
    Route::post('/forgot-password','email')->name('email');
    Route::post('/password/reset','update')->name('update');
});

Route::get('/dashboard', function(){
    return view('admin.pages.dashboard.index');
})->middleware('checkLogin')->name('dashboard');

Route::get('/trang-chu', function(){
    return view('themes.index');
})->name('homepage');

Route::get('/test', function() {

});

Route::get('/login/google/redirect', [SocialiteController::class, 'redirect_google'])->name('google.redirect');
Route::get('/login/google/callback', [SocialiteController::class, 'callback_google'])->name('google.callback');

Route::get('/login/facebook/redirect', [SocialiteController::class, 'redirect_facebook'])->name('facebook.redirect');
Route::get('/login/facebook/callback', [SocialiteController::class, 'callback_facebook'])->name('facebook.callback');

Route::get('/verify/code={code}', [RegisterController::class, 'verifyAccount'])->name('verify-user')->middleware('expries');





























// Route::get('/test/code={code}', function(){
//     return 'asd';
// })->name('test-code')->middleware('signed');

// Route::get('test', function() {
//     $url = URL::temporarySignedRoute('test-code', now()->addSeconds(20), [
//         'code' => 111
//     ]);

//     return $url;
// });

// Route::get('/test2', function(){

//     $url = URL::temporarySignedRoute('share-video', now()->addMinute(), [
//         'video' => 123
//     ]);

//     SendMailJob::dispatch(['name' => 'vominhphung', 'email' => 'haivll123123@gmail.com', 'verification_code' => '123123123123123', 'url' => $url]);
// });

// Route::get('/test3/{name}/{email}/{verify}/{url}', function($name, $email, $verify, $url){

//     $data = ['name' => $name, 'verification_code' => $verify, 'url' => $url];

//     dd($data);
// });

// Route::get('/shared-video/{video}', function(\Illuminate\Http\Request $request, $video){
//     if(!$request->hasValidSignature()) {
//         abort(401);
//     }

//     return 'good vid';
// })->name('share-video');

// Route::get('/test4', function(){
//     return view('expired');
// });

// Route::get('/expires', function() {
    
//     $url = URL::temporarySignedRoute('share-video', now()->addMinute(), [
//         'video' => 123
//     ]);

//     echo $url . ' asdsad asd asdasdasd';
//     // return null;
// });