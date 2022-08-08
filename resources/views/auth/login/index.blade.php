@extends('auth.master')
@section('content')
<div id="auth-left">
    <div class="auth-logo">
        <a href="index.html"><img src="{{ asset('assets/images/logo/logo.svg') }}" alt="Logo"></a>
    </div>
    <h1 class="auth-title">Log in.</h1>
    <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>
    @if($errors->has('email') && $errors->has('password'))
        <p class="text-danger">Please enter email and password</p>
    @elseif($errors->has('email'))
        <p class="text-danger">{{$errors->first('email')}}</p>
    @elseif($errors->has('password'))
        <p class="text-danger">{{$errors->first('password')}}</p>
    @endif
    <form action="{{ route('login.signin') }}" method="POST">
        @csrf
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="text" name="email" @if(Cookie::has('email')) value="{{ Cookie::get('email') }}" @endif class="form-control form-control-xl" placeholder="Email">
            <div class="form-control-icon">
                <i class="bi bi-person"></i>
            </div>
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="password" name="password" @if(Cookie::has('password')) value="{{ Cookie::get('password') }}" @endif class="form-control form-control-xl" placeholder="Password">
            <div class="form-control-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
        </div>
        <div class="form-check form-check-lg d-flex align-items-end">
            <input class="form-check-input me-2" type="checkbox" id="rememberme" name="rememberme" @if(Cookie::has('email')) checked @endif>
            <label class="form-check-label text-gray-600" for="flexCheckDefault">
                Keep me logged in
            </label>
        </div>
        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
    </form>
    <div class="text-center mt-5 text-lg fs-4">
        <a class="btn btn-primary" style="background-color: #3b5998;" href="{{ route("facebook.redirect") }}" role="button">
            <i class="fab fa-facebook-f me-2"></i>Facebook
        </a>
        <a class="btn btn-primary" style="background-color: #dd4b39;" href="{{ route("google.redirect") }}" role="button">
            <i class="fab fa-google me-2"></i>Google
        </a>
    </div>
    <div class="text-center mt-5 text-lg fs-4">
        <p class="text-gray-600">Don't have an account? <a href="{{ route('register.index') }}" class="font-bold">Sign
                up</a>.</p>
        <p><a class="font-bold" href="{{ route('password.index') }}">Forgot password?</a>.</p>
    </div>
</div>
@endsection
@section('foot')
@include('alert-flash-message')
@endsection