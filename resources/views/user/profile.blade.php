@extends('layouts.master')

@section('title', 'Hồ sơ cá nhân')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Hồ sơ cá nhân</h2>

    {{-- Thông báo khi cập nhật thành công --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Hiển thị lỗi validate --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.updateProfile') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="HoTen" class="form-label">Họ và tên</label>
            <input type="text" name="HoTen" id="HoTen" class="form-control" 
                   value="{{ old('HoTen', auth()->user()->HoTen) }}" required>
        </div>

        <div class="mb-3">
            <label for="Email" class="form-label">Email</label>
            <input type="email" name="Email" id="Email" class="form-control" 
                   value="{{ old('Email', auth()->user()->Email) }}" readonly>
        </div>

        <div class="mb-3">
            <label for="SoDienThoai" class="form-label">Số điện thoại</label>
            <input type="text" name="SoDienThoai" id="SoDienThoai" class="form-control" 
                   value="{{ old('SoDienThoai', auth()->user()->SoDienThoai) }}">
        </div>

        <div class="mb-3">
            <label for="DiaChi" class="form-label">Địa chỉ</label>
            <input type="text" name="DiaChi" id="DiaChi" class="form-control" 
                   value="{{ old('DiaChi', auth()->user()->DiaChi) }}">
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>

    <hr class="my-4">

    <h4>Đổi mật khẩu</h4>
    <form action="{{ route('user.updatePassword') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
            <input type="password" name="current_password" id="current_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="new_password" class="form-label">Mật khẩu mới</label>
            <input type="password" name="new_password" id="new_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-warning">Đổi mật khẩu</button>
    </form>
</div>
@endsection
