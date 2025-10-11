@extends('layouts.master')

@section('title', $sanPham->TenSanPham)

@section('content')
<div class="container my-5">
    <div class="row">
        <!-- Cột hình ảnh sản phẩm -->
        <div class="col-md-5 text-center">
            <img src="{{ asset('images/sanpham/'.$sanPham->HinhAnh) }}" 
                 alt="{{ $sanPham->TenSanPham }}" 
                 class="img-fluid rounded shadow-sm mb-3">
        </div>

        <!-- Cột thông tin sản phẩm -->
        <div class="col-md-7">
            <h2 class="mb-3">{{ $sanPham->TenSanPham }}</h2>
            <h4 class="text-danger fw-bold mb-3">
                {{ number_format($sanPham->Gia, 0, ',', '.') }} VNĐ
            </h4>

            <p><strong>Mô tả:</strong> {{ $sanPham->MoTa }}</p>
            <p><strong>Thương hiệu:</strong> {{ $sanPham->thuongHieu->TenThuongHieu }}</p>
            <p><strong>Loại:</strong> {{ $sanPham->loaiSanPham->TenLoai }}</p>

            <form action="{{ route('giohang.add', $sanPham->SanPhamID) }}" method="POST" class="mb-3">
                @csrf
                <button type="submit" class="btn btn-success me-2">
                    🛒 Thêm vào giỏ hàng
                </button>
                <a href="{{ url('/sanpham') }}" class="btn btn-outline-secondary">
                    ← Trở lại danh sách
                </a>
            </form>
        </div>
    </div>
</div>
@endsection

{{--  --}}
