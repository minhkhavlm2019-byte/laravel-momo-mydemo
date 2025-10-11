@extends('layouts.master')

@section('title', 'Danh sách sản phẩm')

@section('content')
<h2 class="text-center my-4">🛒 Giỏ hàng của bạn</h2>

@if(empty($giohang))
    <div class="alert alert-info text-center">
        Giỏ hàng trống.
    </div>
@else
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tổng</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($giohang as $id => $item)
                    <tr>
                        <td>{{ $item['TenSanPham'] }}</td>
                        <td class="text-end text-danger">{{ number_format($item['Gia'], 0, ',', '.') }} VNĐ</td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <form action="{{ route('giohang.giam', $id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-outline-secondary btn-sm">−</button>
                                </form>

                                <span class="px-3 d-inline-block align-middle">{{ $item['SoLuong'] }}</span>

                                <form action="{{ route('giohang.tang', $id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-outline-secondary btn-sm">+</button>
                                </form>
                            </div>
                        </td>
                        <td class="text-end fw-bold">
                            {{ number_format($item['Gia'] * $item['SoLuong'], 0, ',', '.') }} VNĐ
                        </td>
                        <td class="text-center">
                            <form action="{{ route('giohang.xoa', $id) }}" method="POST" onsubmit="return confirm('Xoá sản phẩm này?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm">🗑️ Xoá</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Tổng tiền + Đặt hàng + Xoá giỏ hàng -->
    <div class="d-flex justify-content-between align-items-center mt-4">
        <h5 class="mb-0 text-success">
            Tổng tiền: 
            {{ number_format(collect($giohang)->sum(fn($sp) => $sp['Gia'] * $sp['SoLuong']), 0, ',', '.') }} VNĐ
        </h5>

        <div class="d-flex gap-2">
            <!-- Xoá toàn bộ giỏ hàng -->
            <form action="{{ route('giohang.xoaToanBo') }}" method="POST" onsubmit="return confirm('Xoá toàn bộ giỏ hàng?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-dark">🧹 Xoá toàn bộ</button>
            </form>

            <!-- Đặt hàng -->
            <form action="{{ route('donhang.store') }}" method="POST">
                @csrf
                <input type="hidden" name="TongTien" 
                    value="{{ collect($giohang)->sum(fn($sp) => $sp['Gia'] * $sp['SoLuong']) }}">
                <button type="submit" class="btn btn-success mt-3 w-100">✅ Mua hàng</button>
            </form>

        </div>
    </div>
@endif
@endsection