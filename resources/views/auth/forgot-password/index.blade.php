@extends('auth.master')
@section('content')
<div id="auth-left">
    <div class="auth-logo">
        <a href="index.html"><img src="{{ asset('assets/images/logo/logo.svg') }}" alt="Logo"></a>
    </div>
    <h1 class="auth-title">Forgot password.</h1>
    <p class="auth-subtitle mb-5">If you did not give us a real email address when you created your account, we cannot send you an email.</p>
    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <p class="text-gray-600">Don't have an account? <a href="{{ route('register.index') }}" class="font-bold">Sign
        up</a>.</p>
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="text" name="email" class="form-control form-control-xl" placeholder="Email">
            <div class="form-control-icon">
                <i class="bi bi-person"></i>
            </div>
        </div>
        @if($errors->has('email'))
        <p class="text-danger">{{$errors->first('email')}}</p>
        @endif
        <p class="text-gray-600">Already have an account? <a href="{{ route('login.index') }}" class="font-bold">Sign
        in</a>.</p>
        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Submit</button>
    </form>
</div>
@endsection
@section('foot')
@include('alert-flash-message')
@endsection