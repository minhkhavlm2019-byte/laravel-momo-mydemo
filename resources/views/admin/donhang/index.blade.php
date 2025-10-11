@extends('layouts.master')

@section('title', 'Quản lý đơn hàng')

@section('content')
<div class="container">
    <h2 class="mb-4">Danh sách đơn hàng</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($donHangs as $donHang)
                <tr>
                    <td>{{ $donHang->DonHangID }}</td>
                    <td>{{ $donHang->user->HoTen ?? 'N/A' }}</td>
                    <td>{{ $donHang->NgayDat }}</td>
                    <td class="text-danger fw-bold">{{ number_format($donHang->TongTien, 0, ',', '.') }} VNĐ</td>
                    <td>
                        <span class="badge bg-{{ $donHang->TrangThai == 'Hoàn thành' ? 'success' : 'warning' }}">
                            {{ $donHang->TrangThai }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.donhang.show', $donHang->DonHangID) }}" class="btn btn-info btn-sm">Xem</a>
                        <form action="{{ route('admin.donhang.destroy', $donHang->DonHangID) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Xóa đơn hàng này?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $donHangs->links() }} {{-- Phân trang --}}
</div>
@endsection
