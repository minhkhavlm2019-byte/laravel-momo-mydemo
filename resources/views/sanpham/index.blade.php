@extends('layouts.master')

@section('title', 'Danh sách sản phẩm')

@section('content')
<div class="container my-4">
    <div class="header__search">
        {{-- 🔍 FORM TÌM KIẾM & LỌC SẢN PHẨM --}}
        <form method="GET" action="{{ route('sanpham.index') }}" class="mb-5">
            <div class="row g-3 align-items-end">
                {{-- Logo 
                <div class="col-md-2 col-12 text-center">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid" style="max-height: 60px;">
                    </a>
                </div>--}}

                {{-- Ô tìm kiếm --}}
                <div class="col-md-3 col-12">
                    <label for="keyword" class="form-label fw-bold">Tìm kiếm</label>
                    <input type="text" name="keyword" id="keyword"
                        value="{{ request('keyword') }}"
                        class="form-control" placeholder="Nhập tên sản phẩm...">
                </div>

                {{-- Lọc loại sản phẩm --}}
                <div class="col-md-2 col-6">
                    <label for="loai" class="form-label fw-bold">Loại sản phẩm</label>
                    <select name="loai" id="loai" class="form-select">
                        <option value="">-- Tất cả --</option>
                        @foreach($dsLoai as $loai)
                            <option value="{{ $loai->LoaiID }}" {{ request('loai') == $loai->LoaiID ? 'selected' : '' }}>
                                {{ $loai->TenLoai }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Lọc thương hiệu --}}
                <div class="col-md-2 col-6">
                    <label for="thuonghieu" class="form-label fw-bold">Thương hiệu</label>
                    <select name="thuonghieu" id="thuonghieu" class="form-select">
                        <option value="">-- Tất cả --</option>
                        @foreach($dsThuongHieu as $th)
                            <option value="{{ $th->ThuongHieuID }}" {{ request('thuonghieu') == $th->ThuongHieuID ? 'selected' : '' }}>
                                {{ $th->TenThuongHieu }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Khoảng giá --}}
                <div class="col-md-2 col-12">
                    <label class="form-label fw-bold">Giá từ - đến</label>
                    <div class="d-flex gap-1">
                        <input type="number" name="gia_min" value="{{ request('gia_min') }}" class="form-control" placeholder="Min">
                        <input type="number" name="gia_max" value="{{ request('gia_max') }}" class="form-control" placeholder="Max">
                    </div>
                </div>

                {{-- Nút lọc --}}
                <div class="col-md-1 col-12 text-center">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i> Lọc
                    </button>
                </div>
            </div>
        </form>
    </div>
    {{-- 🛍 DANH SÁCH SẢN PHẨM --}}
    <h2 class="text-center mb-4">Danh sách sản phẩm</h2>
    <div class="row g-4">
        @forelse($dsSanPham as $sp)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm border-0">
                    <img src="{{ asset('images/sanpham/'.$sp->HinhAnh) }}" 
                         class="card-img-top img-fluid rounded-top"
                         alt="{{ $sp->TenSanPham }}"
                         onerror="this.src='{{ asset('images/no-image.png') }}';">

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $sp->TenSanPham }}</h5>
                        <p class="card-text text-danger fw-bold">
                            {{ number_format($sp->Gia, 0, ',', '.') }} VNĐ
                        </p>
                        <p class="small text-muted mb-2">
                            {{ $sp->thuonghieu->TenThuongHieu ?? 'Không rõ thương hiệu' }}
                        </p>
                        <a href="{{ route('sanpham.show', $sp->SanPhamID) }}" 
                           class="btn btn-outline-primary mt-auto">
                           Xem chi tiết
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted">
                <p>Không tìm thấy sản phẩm nào phù hợp.</p>
            </div>
        @endforelse
    </div>
</div>
<div class="d-flex mydecoration justify-content-center mt-4">
    {{ $dsSanPham->links('pagination::bootstrap-5') }}
</div>

@endsection
