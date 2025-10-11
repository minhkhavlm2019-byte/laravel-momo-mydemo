@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- Thống kê nhanh --}}
        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card text-white bg-primary shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Đơn hàng</h5>
                    <p class="card-text fs-3 fw-bold">{{ $soDonHang }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card text-white bg-success shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Khách hàng</h5>
                    <p class="card-text fs-3 fw-bold">{{ $soKhachHang }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card text-white bg-warning shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Doanh thu</h5>
                    <p class="card-text fs-3 fw-bold">{{ number_format($tongDoanhThu, 0, ',', '.') }} VNĐ</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
            <div class="card text-white bg-danger shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">Sản phẩm</h5>
                    <p class="card-text fs-3 fw-bold">{{ $soSanPham }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Biểu đồ thống kê --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Thống kê đơn hàng theo tháng</h5>
                </div>
                <div class="card-body">
                    <canvas id="ordersChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('ordersChart').getContext('2d');
    const ordersChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Số đơn hàng',
                data: @json($data),
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
