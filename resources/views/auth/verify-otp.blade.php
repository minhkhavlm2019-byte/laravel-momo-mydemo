@extends('layouts.master')
@section('title', 'Xác thực tài khoản')
@section('content')
<div class="container mt-5">
    <h3>Xác thực tài khoản</h3>
    <form method="POST" action="{{ route('otp.verify.submit') }}">
        @csrf
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ session('email') }}" class="form-control" readonly>
        </div>
        <div class="mb-3">
            <label>Mã OTP</label>
            <input type="text" name="otp" class="form-control" placeholder="Nhập mã xác thực">
        </div>
        <button class="btn btn-success w-100">Xác thực</button>
    </form>
</div>
@endsection
