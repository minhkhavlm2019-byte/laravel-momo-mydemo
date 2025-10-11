@extends('layouts.admin')

@section('title', 'Thêm sản phẩm mới')

@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold text-primary mb-4">Thêm sản phẩm mới</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.sanpham.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tên sản phẩm</label>
                        <input type="text" name="TenSanPham" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Giá</label>
                        <input type="number" name="Gia" class="form-control" min="0" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold">Mô tả</label>
                        <textarea name="MoTa" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Số lượng tồn</label>
                        <input type="number" name="SoLuongTon" class="form-control" min="0" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Loại sản phẩm</label>
                        <select name="LoaiID" class="form-select" required>
                            <option value="">-- Chọn loại --</option>
                            @foreach($dsLoai as $loai)
                                <option value="{{ $loai->LoaiID }}">{{ $loai->TenLoai }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Thương hiệu</label>
                        <select name="ThuongHieuID" class="form-select" required>
                            <option value="">-- Chọn thương hiệu --</option>
                            @foreach($dsThuongHieu as $th)
                                <option value="{{ $th->ThuongHieuID }}">{{ $th->TenThuongHieu }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Hình ảnh</label>
                        <input type="file" name="HinhAnh" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Trạng thái</label>
                        <select name="TrangThai" class="form-select">
                            <option value="Còn hàng">Còn hàng</option>
                            <option value="Hết hàng">Hết hàng</option>
                            <option value="Ngừng kinh doanh">Ngừng kinh doanh</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Lưu sản phẩm
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
