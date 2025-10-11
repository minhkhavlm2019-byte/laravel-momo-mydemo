<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use App\Models\NguoiDung;
use App\Models\SanPham;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $soDonHang   = DonHang::count();
        $soKhachHang = NguoiDung::where('VaiTro', 'KhachHang')->count();
        $tongDoanhThu = DonHang::sum('TongTien');
        $soSanPham   = SanPham::count();

        // Thống kê đơn hàng theo tháng
        $orders = DonHang::select(
                DB::raw('MONTH(NgayDat) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = $orders->pluck('month')->map(fn($m) => "Tháng $m");
        $data   = $orders->pluck('count');

        return view('admin.dashboard', compact(
            'soDonHang',
            'soKhachHang',
            'tongDoanhThu',
            'soSanPham',
            'labels',
            'data'
        ));
    }
}
