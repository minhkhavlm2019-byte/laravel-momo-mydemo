<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use App\Models\LoaiSanPham;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy 4 loại sản phẩm để hiển thị danh mục
        $danhmuc = LoaiSanPham::take(4)->get();

        // Lấy 8 sản phẩm nổi bật
        $sanphams = SanPham::with(['thuongHieu','loaiSanPham'])
            ->orderBy('SanPhamID', 'desc') // tạm thời sort theo ID mới nhất
            ->take(8)
            ->get();

        return view('home', compact('danhmuc', 'sanphams'));
    }
}
