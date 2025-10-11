@extends('layouts.master')

@section('title', 'Đăng ký')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">Đăng ký tài khoản</h2>

                    {{-- Hiển thị lỗi validate --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.submit') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="HoTen" class="form-label">Họ tên</label>
                            <input type="text" class="form-control" id="HoTen" name="HoTen" required>
                        </div>

                        <div class="mb-3">
                            <label for="Email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="Email" name="Email" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="MatKhau" class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" id="MatKhau" name="MatKhau" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="MatKhau_confirmation" class="form-label">Xác nhận mật khẩu</label>
                                <input type="password" class="form-control" id="MatKhau_confirmation" name="MatKhau_confirmation" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="SoDienThoai" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="SoDienThoai" name="SoDienThoai">
                        </div>

                        <div class="mb-3">
                            <label for="DiaChi" class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control" id="DiaChi" name="DiaChi">
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            Đăng ký
                        </button>
                    </form>

                    <p class="mt-3 text-center">
                        Đã có tài khoản? 
                        <a href="{{ route('login') }}">Đăng nhập ngay</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
