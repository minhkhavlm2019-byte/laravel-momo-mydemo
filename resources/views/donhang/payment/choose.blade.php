@extends('layouts.master')

@section('title', 'Chọn phương thức thanh toán')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">Chọn phương thức thanh toán</h2>

    <div class="card p-4">
        <p><strong>Mã đơn hàng:</strong> {{ $donhang->DonHangID }}</p>
        <p><strong>Tổng tiền:</strong> {{ number_format($donhang->TongTien, 0, ',', '.') }} VNĐ</p>

        <div class="row text-center mt-4">
            <div class="col-md-6">
                <form action="{{ route('payment.momo') }}" method="GET">
                    @csrf
                    <input type="hidden" name="DonHangID" value="{{ $donhang->DonHangID }}">
                    <button type="submit" class="btn btn-danger w-100">Thanh toán bằng MoMo</button>
                </form>
            </div>
            <div class="col-md-6">
                <form action="{{ route('payment.cod') }}" method="POST">
                    @csrf
                    <input type="hidden" name="DonHangID" value="{{ $donhang->DonHangID }}">
                    <button type="submit" class="btn btn-success w-100">Thanh toán khi nhận hàng (COD)</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
