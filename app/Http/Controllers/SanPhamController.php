<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use Illuminate\Http\Request;

class SanPhamController extends Controller
{
    // Hiển thị danh sách sản phẩm
    /*public function index()
    {
        $dsSanPham = SanPham::with(['thuongHieu','loaiSanPham'])->get();
        return view('sanpham.index', compact('dsSanPham'));
    }*/
    public function index(Request $request)
{
    $query = SanPham::with(['thuongHieu','loaiSanPham']);

    if ($request->keyword) {
        $query->where('TenSanPham', 'like', '%' . $request->keyword . '%');
    }

    if ($request->loai) {
        $query->where('LoaiID', $request->loai);
    }

    if ($request->thuonghieu) {
        $query->where('ThuongHieuID', $request->thuonghieu);
    }

    if ($request->gia_min) {
        $query->where('Gia', '>=', $request->gia_min);
    }

    if ($request->gia_max) {
        $query->where('Gia', '<=', $request->gia_max);
    }

    // ✅ Chỉ lấy 12 sản phẩm/trang
    $dsSanPham = $query->paginate(12);

    // ✅ Cache danh mục & thương hiệu (tăng tốc)
    $dsLoai = \Illuminate\Support\Facades\Cache::remember('dsLoai', 3600, fn() => \App\Models\LoaiSanPham::all());
    $dsThuongHieu = \Illuminate\Support\Facades\Cache::remember('dsThuongHieu', 3600, fn() => \App\Models\ThuongHieu::all());

    return view('sanpham.index', compact('dsSanPham', 'dsLoai', 'dsThuongHieu'));
}


    // Hiển thị chi tiết sản phẩm
    public function show($id)
    {
        $sanPham = SanPham::with(['thuongHieu','loaiSanPham'])->findOrFail($id);
        return view('sanpham.detail', compact('sanPham'));
    }
    
}
