@extends('layouts.master')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container">
    <h2 class="mb-4">Chi tiết đơn hàng #{{ $donHang->DonHangID }}</h2>

    {{-- Thông tin khách hàng --}}
    <div class="card mb-4">
        <div class="card-header">Khách hàng</div>
        <div class="card-body">
            <p><strong>Họ tên:</strong> {{ $donHang->user->HoTen ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $donHang->user->Email ?? 'N/A' }}</p>
            <p><strong>SĐT:</strong> {{ $donHang->user->SoDienThoai ?? 'N/A' }}</p>
            <p><strong>Địa chỉ:</strong> {{ $donHang->user->DiaChi ?? 'N/A' }}</p>
        </div>
    </div>

    {{-- Chi tiết sản phẩm --}}
    <div class="card mb-4">
        <div class="card-header">Danh sách sản phẩm</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($donHang->chiTietDonHangs as $ct)
                        <tr>
                            <td>{{ $ct->sanPham->TenSanPham ?? 'Sản phẩm đã xóa' }}</td>
                            <td>{{ number_format($ct->DonGia, 0, ',', '.') }} VNĐ</td>
                            <td>{{ $ct->SoLuong }}</td>
                            <td>{{ number_format($ct->DonGia * $ct->SoLuong, 0, ',', '.') }} VNĐ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <h5 class="text-end mt-3">Tổng tiền: 
                <span class="text-danger fw-bold">{{ number_format($donHang->TongTien, 0, ',', '.') }} VNĐ</span>
            </h5>
        </div>
    </div>

    {{-- Cập nhật trạng thái --}}
    <div class="card mb-4">
        <div class="card-header">Cập nhật trạng thái</div>
        <div class="card-body">
            <form action="{{ route('admin.donhang.update', $donHang->DonHangID) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <select name="TrangThai" class="form-select">
                        <option value="Chờ xử lý" {{ $donHang->TrangThai == 'Chờ xử lý' ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="Đang giao" {{ $donHang->TrangThai == 'Đang giao' ? 'selected' : '' }}>Đang giao</option>
                        <option value="Hoàn thành" {{ $donHang->TrangThai == 'Hoàn thành' ? 'selected' : '' }}>Hoàn thành</option>
                        <option value="Hủy" {{ $donHang->TrangThai == 'Hủy' ? 'selected' : '' }}>Hủy</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('admin.donhang.index') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>
@endsection
