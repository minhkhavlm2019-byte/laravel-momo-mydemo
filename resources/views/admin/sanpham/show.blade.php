@extends('layouts.admin')

@section('title', 'Chi tiết sản phẩm')

@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold text-primary mb-4">Chi tiết sản phẩm</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <img src="{{ asset('images/sanpham/' . $sanpham->HinhAnh) }}" 
                         class="img-fluid rounded shadow-sm" 
                         alt="{{ $sanpham->TenSanPham }}"
                         onerror="this.src='{{ asset('images/no-image.png') }}';">
                </div>
                <div class="col-md-7">
                    <h3>{{ $sanpham->TenSanPham }}</h3>
                    <p class="text-danger fw-bold fs-5">{{ number_format($sanpham->Gia, 0, ',', '.') }} VNĐ</p>
                    <p><strong>Mô tả:</strong> {{ $sanpham->MoTa ?? 'Chưa có mô tả.' }}</p>
                    <p><strong>Loại:</strong> {{ $sanpham->loaiSanPham->TenLoai ?? '—' }}</p>
                    <p><strong>Thương hiệu:</strong> {{ $sanpham->thuongHieu->TenThuongHieu ?? '—' }}</p>
                    <p><strong>Số lượng tồn:</strong> {{ $sanpham->SoLuongTon }}</p>
                    <p><strong>Ngày nhập:</strong> {{ \Carbon\Carbon::parse($sanpham->NgayNhap)->format('d/m/Y') }}</p>
                    <p><strong>Trạng thái:</strong> 
                        @if($sanpham->TrangThai == 'Còn hàng')
                            <span class="badge bg-success">Còn hàng</span>
                        @else
                            <span class="badge bg-secondary">Ngừng kinh doanh</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <a href="{{ route('admin.sanpham.edit', $sanpham->SanPhamID) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Sửa
        </a>
        <a href="{{ route('admin.sanpham.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
</div>
@endsection
