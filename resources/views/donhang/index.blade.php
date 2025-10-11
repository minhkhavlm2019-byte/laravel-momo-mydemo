@extends('layouts.master')

@section('title', 'Đơn hàng của tôi')

@section('content')
<div class="container">
    <h2 class="mb-4">Đơn hàng của tôi</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($donhangs->count() > 0)
        @foreach($donhangs as $dh)
            <div class="card mb-3">
                <div class="card-header">
                    <strong>Đơn hàng #{{ $dh->DonHangID }}</strong> 
                    - Ngày đặt: {{ $dh->NgayDat }} 
                    - Trạng thái: <span class="badge bg-info">{{ $dh->TrangThai }}</span>
                </div>
                <div class="card-body">
                    <ul>
                        @foreach($dh->chiTiet as $ct)
                            <li>
                                {{ $ct->sanPham->TenSanPham ?? 'Sản phẩm đã xóa' }} 
                                x {{ $ct->SoLuong }} 
                                ({{ number_format($ct->DonGia, 0, ',', '.') }} VNĐ)
                            </li>
                        @endforeach
                    </ul>
                    <p><strong>Tổng tiền: {{ number_format($dh->TongTien, 0, ',', '.') }} VNĐ</strong></p>
                </div>
            </div>
        @endforeach
    @else
        <p>Bạn chưa có đơn hàng nào.</p>
    @endif
</div>
@endsection
