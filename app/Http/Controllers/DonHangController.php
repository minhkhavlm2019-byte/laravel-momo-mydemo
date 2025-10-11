<?php

// app/Http/Controllers/DonHangController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;

class DonHangController extends Controller
{
    /*
    // Tạo đơn hàng từ giỏ hàng
    public function store(Request $request)
    {
        $giohang = session()->get('giohang', []);
        if (empty($giohang)) {
            return back()->with('error', 'Giỏ hàng trống!');
        }

        // Tạo đơn hàng mới
        $donhang = DonHang::create([
            'UserID' => Auth::id(),
            'NgayDat' => now(),
            'TongTien' => collect($giohang)->sum(fn($sp) => $sp['Gia'] * $sp['SoLuong']),
            'TrangThai' => 'Chờ xử lý',
        ]);

        // Lưu chi tiết đơn hàng
        foreach ($giohang as $id => $item) {
            ChiTietDonHang::create([
                'DonHangID' => $donhang->DonHangID,
                'SanPhamID' => $id,
                'SoLuong' => $item['SoLuong'],
                'GiaLucMua' => $item['Gia'],
            ]);
        }

        // Xóa giỏ hàng
        session()->forget('giohang');

        return redirect()->route('payment.choose', ['id' => $donhang->DonHangID]);
    }

public function store(Request $request)
{
    $giohang = session()->get('giohang', []);
    if (empty($giohang)) {
        return back()->with('error', 'Giỏ hàng trống!');
    }

    // Lấy phương thức thanh toán
    $phuongThuc = $request->input('PhuongThucThanhToan', 'COD');

    // 1️⃣ Tạo đơn hàng mới
    $donhang = DonHang::create([
        'UserID' => Auth::id(),
        'NgayDat' => now(),
        'TongTien' => collect($giohang)->sum(fn($sp) => $sp['Gia'] * $sp['SoLuong']),
        'TrangThai' => 'Chờ xử lý',
        'PhuongThucThanhToan' => $phuongThuc,
    ]);

    // 2️⃣ Lưu chi tiết đơn hàng
    foreach ($giohang as $id => $item) {
        ChiTietDonHang::create([
            'DonHangID' => $donhang->DonHangID,
            'SanPhamID' => $id,
            'SoLuong' => $item['SoLuong'],
            'GiaLucMua' => $item['Gia'],
        ]);
    }

    // 3️⃣ Xóa giỏ hàng
    session()->forget('giohang');

    // 4️⃣ Điều hướng theo phương thức thanh toán
    if ($phuongThuc === 'MoMo') {
        // Gửi sang PaymentController@momo
        return redirect()->route('payment.momo', ['DonHangID' => $donhang->DonHangID]);
    }

    // Nếu COD → chỉ hiển thị thông báo thành công
    return view('payment.success', ['method' => 'COD']);
} */
    public function store(Request $request)
    {
        // 1️⃣ Lấy giỏ hàng từ session
        $giohang = session()->get('giohang', []);
        if (empty($giohang)) {
            return back()->with('error', 'Giỏ hàng trống!');
        }

        // 2️⃣ Tính tổng tiền
        $tongTien = collect($giohang)->sum(fn($sp) => $sp['Gia'] * $sp['SoLuong']);

        // 3️⃣ Tạo đơn hàng mới
        $donhang = DonHang::create([
            'UserID' => Auth::id(),
            'NgayDat' => now(),
            'TongTien' => $tongTien,
            'TrangThai' => 'Chờ thanh toán',
            'PhuongThucThanhToan' => $request->PhuongThucThanhToan,
        ]);

        // 4️⃣ Lưu chi tiết đơn hàng
        foreach ($giohang as $id => $item) {
            ChiTietDonHang::create([
                'DonHangID' => $donhang->DonHangID,
                'SanPhamID' => $id,
                'SoLuong' => $item['SoLuong'],
                'GiaLucMua' => $item['Gia'],
            ]);
        }

        // 5️⃣ Xóa giỏ hàng sau khi đặt
        session()->forget('giohang');

        return redirect()->route('payment.checkout', ['DonHangID' => $donhang->DonHangID]);
        // Nếu phương thức không hợp lệ
        return back()->with('error', 'Phương thức thanh toán không hợp lệ!');
    }


    // Trang checkout (hiển thị donhang/store.blade.php)
    public function checkout()
    {
        $giohang = session()->get('giohang', []);
        if (empty($giohang)) {
            return redirect()->route('giohang.index')->with('error', 'Giỏ hàng trống!');
        }

        return view('donhang.store');
    }
    
    // Hiển thị danh sách đơn hàng của user
    public function index()
    {
        $donhangs = DonHang::where('UserID', Auth::id())
            ->with('chiTiet.sanPham')
            ->orderBy('NgayDat', 'desc')
            ->get();

        return view('donhang.index', compact('donhangs'));
    }
}
