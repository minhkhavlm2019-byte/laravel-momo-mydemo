@extends('layouts.master')

@section('title', 'Trang chủ - Mỹ Phẩm Store')

@section('content')
<div class="container mt-4">

    {{-- Banner --}}
    <div id="carouselExample" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/banner1.jpg') }}" class="d-block w-100 rounded" alt="Banner 1">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/banner2.jpg') }}" class="d-block w-100 rounded" alt="Banner 2">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/banner3.jpg') }}" class="d-block w-100 rounded" alt="Banner 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
    {{-- Danh mục sản phẩm --}}
    <div class="home__danhmuc bg-light ">
        <h2 class="text-center mb-4">Danh mục sản phẩm</h2>
        <div class="row  text-center mb-3">
            @foreach($danhmuc as $dm)
                <div class="col-md-3 col-6 mb-3">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('images/danhmuc/'.$dm->HinhAnh) }}" 
                            class="card-img-top" alt="{{ $dm->TenLoai }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $dm->TenLoai }}</h5>
                            <a href="{{ url('/sanpham?loai='.$dm->LoaiID) }}" class="btn btn-outline-primary btn-sm">Xem ngay</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mb-5">
            <a href="{{ url('/sanpham') }}" class="btn btn-primary">Xem thêm danh mục</a>
        </div>

    </div>
    

    {{-- Sản phẩm nổi bật --}}
    <h2 class="text-center mb-4">Sản phẩm nổi bật</h2>
    <div class="row">
        @foreach($sanphams as $sp)
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('images/sanpham/'.$sp->HinhAnh) }}" 
                         class="card-img-top" alt="{{ $sp->TenSanPham }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $sp->TenSanPham }}</h5>
                        <p class="card-text text-danger fw-bold">{{ number_format($sp->Gia, 0, ',', '.') }} VNĐ</p>
                        <a href="{{ route('sanpham.show', $sp->SanPhamID) }}" class="btn btn-success btn-sm">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="text-center">
        <a href="{{ route('sanpham.index') }}" class="btn btn-primary">Xem thêm sản phẩm</a>
    </div>

</div>
@endsection


{{-- <div class="welcome">
        <h2>Chào mừng đến với MyShop</h2>
        <p>Đây là trang chủ của website bán mỹ phẩm.</p>

        <div class="actions">
            <a href="{{ route('sanpham.index') }}" class="btn btn-primary">Xem sản phẩm</a>
            <a href="{{ route('login') }}" class="btn btn-secondary">Đăng nhập</a>
        </div>
    </div> --}}
