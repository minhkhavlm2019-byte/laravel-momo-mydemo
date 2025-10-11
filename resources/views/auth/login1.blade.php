{{-- 
    <h2>Đăng nhập</h2>
    <form method="POST" action="{{ route('login.submit') }}">
        @csrf
        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Mật khẩu:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Đăng nhập</button>
    </form> --}}
@extends('layouts.master')

@section('title', 'Đăng nhập')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">Đăng nhập</h2>

                    {{-- Thông báo lỗi (nếu có) --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.submit') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" 
                                   class="form-control" 
                                   id="email" 
                                   name="email" 
                                   placeholder="Nhập email" 
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Nhập mật khẩu" 
                                   required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Đăng nhập
                        </button>
                    </form>

                    <p class="mt-3 text-center">
                        Chưa có tài khoản? 
                        <a href="{{ route('register') }}">Đăng ký ngay</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
