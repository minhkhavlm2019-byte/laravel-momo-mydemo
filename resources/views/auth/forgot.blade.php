@extends('layouts.master')
@section('title', 'Quên mật khẩu')
@section('content')
<div class="container mt-5">
    <h3>Quên mật khẩu</h3>
    <form method="POST" action="{{ route('password.sendOtp') }}">
        @csrf
        <input type="email" name="email" class="form-control mb-3" placeholder="Nhập email của bạn">
        <button class="btn btn-primary w-100">Gửi mã OTP</button>
    </form>
</div>
@endsection
