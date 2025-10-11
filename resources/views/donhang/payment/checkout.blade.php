@extends('layouts.master')

@section('title', 'Thanh toán đơn hàng')

@section('content')
<div class="container py-4">
    {{--     --}}
    <h2 class="text-center mb-4">💳 Thanh toán đơn hàng #{{ $donhang->DonHangID }}</h2>

    <p><strong>Tổng tiền:</strong> {{ number_format($donhang->TongTien, 0, ',', '.') }} VNĐ</p>

    <form action="{{ route('payment.momo') }}" method="POST" class="mb-3">
        @csrf
        <input type="hidden" name="DonHangID" value="{{ $donhang->DonHangID }}">
        <button class="btn btn-danger w-100">Thanh toán bằng MoMo</button>
    </form>

    <form action="{{ route('payment.cod') }}" method="POST">
        @csrf
        <input type="hidden" name="DonHangID" value="{{ $donhang->DonHangID }}">
        <button class="btn btn-secondary w-100">Thanh toán khi nhận hàng (COD)</button>
    </form>
</div>
@endsection
