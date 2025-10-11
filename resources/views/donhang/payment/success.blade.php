@extends('layouts.master')

@section('title', 'Thanh toán thành công')

@section('content')
<div class="container py-5 text-center">
    <h2>🎉 Mua hàng thành công!</h2>
    <p>Phương thức: <strong>{{ $method }}</strong></p>
    <a href="/" class="btn btn-primary mt-3">Quay về trang chủ</a>
</div>
@endsection
