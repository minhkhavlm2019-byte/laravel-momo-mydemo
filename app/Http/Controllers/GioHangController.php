<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham;

class GioHangController extends Controller
{
    public function index()
    {
        $giohang = session()->get('giohang', []);
        return view('giohang.index', compact('giohang'));
    }

    public function add(Request $request, $id)
    {
        // Lấy sản phẩm từ DB
        $sanpham = SanPham::findOrFail($id);

        // Lấy giỏ hàng từ session (nếu chưa có thì tạo mới mảng rỗng)
        $giohang = session()->get('giohang', []);

        if (isset($giohang[$id])) {
            // Nếu sản phẩm đã có trong giỏ → tăng số lượng
            $giohang[$id]['SoLuong']++;
        } else {
            // Nếu chưa có → thêm mới
            $giohang[$id] = [
                'TenSanPham' => $sanpham->TenSanPham,
                'Gia' => $sanpham->Gia,
                'SoLuong' => 1,
                'HinhAnh' => $sanpham->HinhAnh ?? 'no-image.jpg',
            ];
        }

        // Lưu lại vào session
        session()->put('giohang', $giohang);

        // Quay lại trang trước với thông báo
        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }
    public function tang($id) {
    $giohang = session('giohang', []);
    if (isset($giohang[$id])) {
        $giohang[$id]['SoLuong']++;
        session(['giohang' => $giohang]);
    }
    return back();
}

    public function giam($id) {
        $giohang = session('giohang', []);
        if (isset($giohang[$id]) && $giohang[$id]['SoLuong'] > 1) {
            $giohang[$id]['SoLuong']--;
            session(['giohang' => $giohang]);
        }
        return back();
    }

    public function xoa($id) {
        $giohang = session('giohang', []);
        unset($giohang[$id]);
        session(['giohang' => $giohang]);
        return back();
    }

    public function xoaToanBo() {
        session()->forget('giohang');
        return back();
    }

}
