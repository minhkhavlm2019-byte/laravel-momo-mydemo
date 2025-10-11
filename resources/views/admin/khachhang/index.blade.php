@extends('layouts.admin')

@section('title', 'Quản lý khách hàng')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">Quản lý khách hàng</h2>

        {{-- Form tìm kiếm --}}
        <form method="GET" action="{{ route('admin.khachhang.index') }}" class="d-flex" style="max-width: 300px;">
            <input type="text" name="keyword" class="form-control me-2" 
                   placeholder="Tìm tên hoặc email..." 
                   value="{{ request('keyword') }}">
            <button class="btn btn-outline-primary">Tìm</button>
        </form>
    </div>

    {{-- Bảng danh sách khách hàng --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-primary">
                    <tr class="text-center">
                        <th width="50">#</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ</th>
                        <th>Vai trò</th>
                        <th>Ngày đăng ký</th>
                        <th width="120">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dsKhachHang as $index => $kh)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $kh->HoTen }}</td>
                            <td>{{ $kh->Email }}</td>
                            <td>{{ $kh->SoDienThoai ?? '—' }}</td>
                            <td>{{ $kh->DiaChi ?? '—' }}</td>
                            <td>
                                @if($kh->VaiTro === 'Admin')
                                    <span class="badge bg-danger">Admin</span>
                                @else
                                    <span class="badge bg-success">Khách hàng</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($kh->NgayDangKy)->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.khachhang.show', $kh->UserID) }}" 
                                   class="btn btn-sm btn-info text-white">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.khachhang.destroy', $kh->UserID) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa người dùng này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Không có khách hàng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Phân trang --}}
    <div class="mt-3">
        {{ $dsKhachHang->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
