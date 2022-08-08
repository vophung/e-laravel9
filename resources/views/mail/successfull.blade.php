@extends('auth.master')
@section('content')
<div id="auth-left">
    <div class="auth-logo">
        <a href="index.html"><img src="{{ asset('assets/images/logo/logo.svg') }}" alt="Logo"></a>
    </div>
    <h1 class="auth-title">Thank You!</h1>
    <p class="auth-subtitle mb-5">Welcome {{ $data['email'] }} to our website.</p>
    <p class="auth-subtitle mb-5">Please check your email to verify your account.</p>
    <div class="text-center mt-5 text-lg fs-4">
        <p class="text-gray-600">Do your already have an account? <a href="{{ route('login.index') }}" class="font-bold">Sign
                in</a>.</p>
        <p><a class="font-bold" href="#">Forgot password?</a>.</p>
    </div>
</div>
@endsection