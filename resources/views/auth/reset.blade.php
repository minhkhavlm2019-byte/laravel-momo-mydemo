@extends('layouts.master')
@section('title', 'Đặt lại mật khẩu')
@section('content')
<div class="container mt-5">
    <h3>Đặt lại mật khẩu</h3>
    <form method="POST" action="{{ route('password.reset') }}">
        @csrf
        <input type="hidden" name="email" value="{{ $email }}">
        <input type="text" name="otp" class="form-control mb-3" placeholder="Nhập mã OTP">
        <input type="password" name="password" class="form-control mb-3" placeholder="Mật khẩu mới">
        <input type="password" name="password_confirmation" class="form-control mb-3" placeholder="Xác nhận mật khẩu">
        <button class="btn btn-success w-100">Cập nhật mật khẩu</button>
    </form>
</div>
@endsection
