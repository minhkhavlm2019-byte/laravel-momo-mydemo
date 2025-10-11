@extends('layouts.admin')

@section('title', 'Chỉnh sửa sản phẩm')

@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold text-primary mb-4">Chỉnh sửa sản phẩm</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.sanpham.update', $sanpham->SanPhamID) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tên sản phẩm</label>
                        <input type="text" name="TenSanPham" value="{{ $sanpham->TenSanPham }}" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Giá</label>
                        <input type="number" name="Gia" value="{{ $sanpham->Gia }}" class="form-control" min="0" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Mô tả</label>
                        <textarea name="MoTa" class="form-control" rows="4">{{ $sanpham->MoTa }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Số lượng tồn</label>
                        <input type="number" name="SoLuongTon" value="{{ $sanpham->SoLuongTon }}" class="form-control" min="0" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Loại sản phẩm</label>
                        <select name="LoaiID" class="form-select" required>
                            @foreach($dsLoai as $loai)
                                <option value="{{ $loai->LoaiID }}" 
                                    {{ $sanpham->LoaiID == $loai->LoaiID ? 'selected' : '' }}>
                                    {{ $loai->TenLoai }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Thương hiệu</label>
                        <select name="ThuongHieuID" class="form-select" required>
                            @foreach($dsThuongHieu as $th)
                                <option value="{{ $th->ThuongHieuID }}" 
                                    {{ $sanpham->ThuongHieuID == $th->ThuongHieuID ? 'selected' : '' }}>
                                    {{ $th->TenThuongHieu }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Hình ảnh</label>
                        <input type="file" name="HinhAnh" class="form-control">
                        @if($sanpham->HinhAnh)
                            <img src="{{ asset('images/sanpham/' . $sanpham->HinhAnh) }}" 
                                 alt="{{ $sanpham->TenSanPham }}" 
                                 class="mt-2 rounded shadow-sm" width="100">
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Trạng thái</label>
                        <select name="TrangThai" class="form-select">
                            <option value="Còn hàng" {{ $sanpham->TrangThai == 'Còn hàng' ? 'selected' : '' }}>Còn hàng</option>
                            <option value="Hết hàng" {{ $sanpham->TrangThai == 'Hết hàng' ? 'selected' : '' }}>Hết hàng</option>
                            <option value="Ngừng kinh doanh" {{ $sanpham->TrangThai == 'Ngừng kinh doanh' ? 'selected' : '' }}>Ngừng kinh doanh</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Cập nhật
                    </button>
                    <a href="{{ route('admin.sanpham.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
