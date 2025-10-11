@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection

@section('title', 'Đăng nhập')

@section('content')
<div class="login">
    <form method="POST" action="{{ route('login.submit') }}" class="login__form">
        @csrf
        <h1 class="login__title">Login</h1>

        {{-- Hiển thị lỗi đăng nhập --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="login__content">
            <div class="login__box">
                <i class="ri-user-3-line login__icon"></i>

                <div class="login__box-input">
                    <input type="email" 
                           name="email" 
                           required 
                           class="login__input" 
                           id="login-email" 
                           placeholder=" "
                           value="{{ old('email') }}">
                    <label for="login-email" class="login__label">Email</label>
                </div>
            </div>

            <div class="login__box">
                <i class="ri-lock-2-line login__icon"></i>

                <div class="login__box-input">
                    <input type="password" 
                           name="password" 
                           required 
                           class="login__input" 
                           id="login-pass" 
                           placeholder=" ">
                    <label for="login-pass" class="login__label">Password</label>
                    <i class="ri-eye-off-line login__eye" id="login-eye"></i>
                </div>
            </div>
        </div>

        <div class="login__check">
            <div class="login__check-group">
                <input type="checkbox" class="login__check-input" id="login-check">
                <label for="login-check" class="login__check-label">Remember me</label>
            </div>

            <a href="{{ route('password.forgot')}}" class="login__forgot">Forgot Password?</a>
        </div>

        <button type="submit" class="login__button">Login</button>

        <p class="login__register">
            Don't have an account?
            <a href="{{ route('register') }}">Register</a>
        </p>
    </form>
</div>
@endsection
