@extends('layouts.master')

@section('title', 'Đặt hàng')

@section('content')
<div class="container">
    <h2 class="mb-4">Xác nhận đơn hàng</h2>

    {{-- Thông tin người dùng --}}
    <div class="card mb-4">
        <div class="card-header">Thông tin khách hàng</div>
        <div class="card-body">
            <p><strong>Họ tên:</strong> {{ Auth::user()->HoTen }}</p>
            <p><strong>Email:</strong> {{ Auth::user()->Email }}</p>
            <p><strong>Số điện thoại:</strong> {{ Auth::user()->SoDienThoai ?? 'Chưa cập nhật' }}</p>
            <p><strong>Địa chỉ:</strong> {{ Auth::user()->DiaChi ?? 'Chưa cập nhật' }}</p>
        </div>
    </div>

    {{-- Thông tin giỏ hàng --}}
    <div class="card mb-4">
        <div class="card-header">Sản phẩm trong giỏ</div>
        <div class="card-body">
            @if(session('giohang') && count(session('giohang')) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tạm tính</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $tongTien = 0; @endphp
                        @foreach(session('giohang') as $id => $item)
                            @php $thanhTien = $item['Gia'] * $item['SoLuong']; @endphp
                            <tr>
                                <td>{{ $item['TenSanPham'] }}</td>
                                <td>{{ number_format($item['Gia'], 0, ',', '.') }} VNĐ</td>
                                <td>{{ $item['SoLuong'] }}</td>
                                <td>{{ number_format($thanhTien, 0, ',', '.') }} VNĐ</td>
                            </tr>
                            @php $tongTien += $thanhTien; @endphp
                        @endforeach
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                            <td class="fw-bold text-danger">{{ number_format($tongTien, 0, ',', '.') }} VNĐ</td>
                        </tr>
                    </tbody>
                </table>
            @else
                <p>Giỏ hàng trống!</p>
            @endif
        </div>
    </div>

    {{-- Form đặt hàng --}}
    <form action="{{ route('payment.pay') }}" method="GET">
        @csrf
        <button type="submit" class="btn btn-success w-100">Xác nhận đặt hàng</button>
    </form>
</div>
@endsection
