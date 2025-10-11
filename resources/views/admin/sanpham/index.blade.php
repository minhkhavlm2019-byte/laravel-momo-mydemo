@extends('layouts.admin')

@section('title', 'Quản lý sản phẩm')

@section('content')
<div class="container-fluid py-4">

    {{-- ✅ Tiêu đề + nút thêm --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary mb-0">
            <i class="fas fa-boxes"></i> Quản lý sản phẩm
        </h2>

        <a href="{{ route('admin.sanpham.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Thêm sản phẩm
        </a>
    </div>

    {{-- ✅ Thông báo flash --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ✅ Form tìm kiếm --}}
    <form method="GET" action="{{ route('admin.sanpham.index') }}" class="mb-3">
        <div class="row g-2">
            <div class="col-md-3 col-sm-6">
                <input type="text" name="keyword" value="{{ request('keyword') }}"
                       class="form-control" placeholder="Tìm theo tên sản phẩm...">
            </div>
            <div class="col-md-2 col-sm-6">
                <select name="loai" class="form-select">
                    <option value="">-- Loại sản phẩm --</option>
                    @foreach($dsLoai as $loai)
                        <option value="{{ $loai->LoaiID }}" 
                            {{ request('loai') == $loai->LoaiID ? 'selected' : '' }}>
                            {{ $loai->TenLoai }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 col-sm-6">
                <select name="thuonghieu" class="form-select">
                    <option value="">-- Thương hiệu --</option>
                    @foreach($dsThuongHieu as $th)
                        <option value="{{ $th->ThuongHieuID }}" 
                            {{ request('thuonghieu') == $th->ThuongHieuID ? 'selected' : '' }}>
                            {{ $th->TenThuongHieu }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 col-sm-6">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Lọc
                </button>
            </div>
        </div>
    </form>

    {{-- ✅ Bảng danh sách sản phẩm --}}
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle table-hover">
                <thead class="table-primary text-center">
                    <tr>
                        <th width="50">#</th>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Loại</th>
                        <th>Thương hiệu</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Trạng thái</th>
                        <th width="160">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dsSanPham as $index => $sp)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">
                                <img src="{{ asset('images/sanpham/'.$sp->HinhAnh) }}" 
                                     alt="{{ $sp->TenSanPham }}" 
                                     class="img-thumbnail" style="width: 70px; height: 70px; object-fit: cover;"
                                     onerror="this.src='{{ asset('images/no-image.png') }}'">
                            </td>
                            <td>{{ $sp->TenSanPham }}</td>
                            <td>{{ $sp->loaiSanPham->TenLoai ?? '—' }}</td>
                            <td>{{ $sp->thuongHieu->TenThuongHieu ?? '—' }}</td>
                            <td class="text-danger fw-bold">{{ number_format($sp->Gia, 0, ',', '.') }} VNĐ</td>
                            <td class="text-center">{{ $sp->SoLuongTon }}</td>
                            <td class="text-center">
                                @if($sp->TrangThai === 'Còn hàng')
                                    <span class="badge bg-success">Còn hàng</span>
                                @elseif($sp->TrangThai === 'Hết hàng')
                                    <span class="badge bg-secondary">Hết hàng</span>
                                @else
                                    <span class="badge bg-danger">Ngừng kinh doanh</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.sanpham.show', $sp->SanPhamID) }}" 
                                   class="btn btn-sm btn-info text-white">
                                   <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.sanpham.edit', $sp->SanPhamID) }}" 
                                   class="btn btn-sm btn-warning text-white">
                                   <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.sanpham.destroy', $sp->SanPhamID) }}" 
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
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
                            <td colspan="9" class="text-center text-muted">Không có sản phẩm nào được tìm thấy.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ✅ Phân trang --}}
    <div class="mt-3">
        {{ $dsSanPham->links('pagination::bootstrap-5') }}
    </div>

</div>
@endsection
