<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

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

Route::controller(LoginController::class)->name('login')->group(function() {
    Route::get('/login', 'index')->name('.index');
    Route::post('/login', 'signin')->name('.signin');
    Route::post('/logout', 'logout')->name('.logout');
});

Route::controller(RegisterController::class)->name('register')->group(function() {
    Route::get('/register', 'index')->name('.index');
    Route::post('/register', 'store')->name('.store');
});

Route::get('/verify', [RegisterController::class, 'verifyAccount'])->name('verify.user');
Route::get('/verify?code={code}')->name('verify.code');

Route::get('/test', function(){
    return view('test');
});