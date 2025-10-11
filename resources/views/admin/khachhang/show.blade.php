@extends('layouts.admin')

@section('title', 'Chi tiết khách hàng')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h3 class="fw-bold text-primary">
                <i class="fas fa-user-circle me-2"></i>Thông tin khách hàng
            </h3>
        </div>
        <div class="col text-end">
            <a href="{{ route('admin.khachhang.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại danh sách
            </a>
        </div>
    </div>

    {{-- Thông tin cá nhân --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <strong>Thông tin cá nhân</strong>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Họ tên:</strong> {{ $khachhang->HoTen }}</p>
                    <p><strong>Email:</strong> {{ $khachhang->Email }}</p>
                    <p><strong>Số điện thoại:</strong> {{ $khachhang->SoDienThoai ?? 'Chưa cập nhật' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Địa chỉ:</strong> {{ $khachhang->DiaChi ?? 'Chưa cập nhật' }}</p>
                    <p><strong>Ngày đăng ký:</strong> {{ $khachhang->NgayDangKy }}</p>
                    <p><strong>Vai trò:</strong> 
                        <span class="badge bg-{{ $khachhang->VaiTro === 'Admin' ? 'danger' : 'success' }}">
                            {{ $khachhang->VaiTro }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Danh sách đơn hàng --}}
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <strong>Đơn hàng của khách hàng</strong>
        </div>
        <div class="card-body">
            @if($donhangs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($donhangs as $dh)
                                <tr>
                                    <td class="text-center">{{ $dh->DonHangID }}</td>
                                    <td>{{ $dh->NgayDat }}</td>
                                    <td class="text-danger fw-bold">{{ number_format($dh->TongTien, 0, ',', '.') }} VNĐ</td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ 
                                            $dh->TrangThai === 'Đã giao' ? 'success' : 
                                            ($dh->TrangThai === 'Đang xử lý' ? 'warning' : 'secondary')
                                        }}">
                                            {{ $dh->TrangThai }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.donhang.show', $dh->DonHangID) }}" 
                                           class="btn btn-sm btn-info text-white">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted text-center">Khách hàng này chưa có đơn hàng nào.</p>
            @endif
        </div>
    </div>
</div>
@endsection
