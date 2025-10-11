@extends('layouts.master')

@section('title', 'Thanh toán thất bại')

@section('content')
<div class="container py-5 text-center">
    <h2>⚠️ Thanh toán thất bại!</h2>
    <p>{{ $message }}</p>
    <a href="/" class="btn btn-secondary mt-3">Thử lại</a>
</div>
@endsection
