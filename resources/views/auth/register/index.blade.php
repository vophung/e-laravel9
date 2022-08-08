@extends('auth.master')
@section('content')
<div id="auth-left">
    <div class="auth-logo">
        <a href="index.html"><img src="assets/images/logo/logo.svg" alt="Logo"></a>
    </div>
    <h1 class="auth-title">Sign Up</h1>
    <p class="auth-subtitle mb-5">Input your data to register to our website.</p>

    <form action="{{ route('register.store') }}" method="POST" id="signup">
        @csrf
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="text" name="email" id="email" value="{{ old('email') }}" class="form-control form-control-xl" placeholder="Email">
            <div class="form-control-icon">
                <i class="bi bi-envelope"></i>
            </div>
            @if($errors->has('email'))
                <p class="text-danger">{{ $errors->first('email') }}</p>
            @endif
            <p class="text-danger"></p>
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="text" class="form-control form-control-xl" value="{{ old('name') }}" name="name" id="name"  placeholder="Username">
            <div class="form-control-icon">
                <i class="bi bi-person"></i>
            </div>
            @if($errors->has('name'))
                <p class="text-danger">{{ $errors->first('name') }}</p>
            @endif
            <p class="text-danger"></p>
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="password" class="form-control form-control-xl" name="password" id="password" placeholder="Password">
            <div class="form-control-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
            @if($errors->has('password'))
                <p class="text-danger">{{ $errors->first('password') }}</p>
            @endif
            <p class="text-danger"></p>
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="password" class="form-control form-control-xl" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
            <div class="form-control-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
            @if($errors->has('confirm_password'))
                <p class="text-danger">{{ $errors->first('confirm_password') }}</p>
            @endif
            <p class="text-danger"></p>
        </div>
        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Sign Up</button>
    </form>
    <div class="text-center mt-5 text-lg fs-4">
        <p class='text-gray-600'>Already have an account? <a href="{{ route('login.index') }}" class="font-bold">Log
                in</a>.</p>
    </div>
</div>
@endsection
@section('foot')
    @include('auth.register.blocks.scripts')
@endsection