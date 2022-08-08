@extends('auth.master')
@section('content')
<div id="auth-left">
    <div class="auth-logo">
        <a href="index.html"><img src="{{ asset('assets/images/logo/logo.svg') }}" alt="Logo"></a>
    </div>
    <h1 class="auth-title">Reset password.</h1>
    <p class="auth-subtitle mb-5">If you change your password successfully, the system will automatically login to the homepage for you.</p>
    <form action="{{ route('password.update') }}" method="POST">
        <input type="hidden" name="token" value="{{ $data['token'] }}">
        @csrf
        <p class="text-gray-600">Don't have an account? <a href="{{ route('register.index') }}" class="font-bold">Sign
        up</a>.</p>
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="text" name="email" value="{{ $data['email'] }}" readonly class="form-control form-control-xl" placeholder="Email">
            <div class="form-control-icon">
                <i class="bi bi-person"></i>
            </div>
            @if($errors->has('email'))
            <p class="text-danger">{{$errors->first('email')}}</p>
            @endif
            @if($errors->has('token'))
            <p class="text-danger">{{$errors->first('token')}}</p>
            @endif
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="password" name="password" class="form-control form-control-xl" placeholder="Password">
            <div class="form-control-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
            @if($errors->has('password'))
            <p class="text-danger">{{$errors->first('password')}}</p>
            @endif
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="password" name="confirm_password" class="form-control form-control-xl" placeholder="Confirm Password">
            <div class="form-control-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
            @if($errors->has('confirm_password'))
            <p class="text-danger">{{$errors->first('confirm_password')}}</p>
            @endif
        </div>
        <p class="text-gray-600">Already have an account? <a href="{{ route('login.index') }}" class="font-bold">Sign
        in</a>.</p>
        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Submit</button>
    </form>
</div>
@endsection
@section('foot')
@include('alert-flash-message')
@endsection