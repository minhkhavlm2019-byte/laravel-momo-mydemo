<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; // ✅ Import đúng
use App\Models\NguoiDung;
use App\Models\DonHang;

class KhachHangController extends Controller
{
    /**
     * Hiển thị danh sách khách hàng (có tìm kiếm + phân trang)
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        $query = NguoiDung::query()
            ->where('VaiTro', 'KhachHang'); // chỉ lấy khách hàng

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('HoTen', 'like', "%$keyword%")
                  ->orWhere('Email', 'like', "%$keyword%");
            });
        }

        $dsKhachHang = $query->orderByDesc('UserID')->paginate(10);

        return view('admin.khachhang.index', compact('dsKhachHang'));
    }

    /**
     * Hiển thị thông tin chi tiết khách hàng
     */
    public function show($id)
    {
        $khachhang = NguoiDung::findOrFail($id);

        // Lấy danh sách đơn hàng của khách
        $donhangs = DonHang::where('UserID', $id)->get();

        return view('admin.khachhang.show', compact('khachhang', 'donhangs'));
    }

    /**
     * Xóa khách hàng (và các đơn hàng liên quan nếu có)
     */
    public function destroy($id)
    {
        $khachHang = NguoiDung::findOrFail($id);

        // Xóa đơn hàng của khách (nếu có)
        DonHang::where('UserID', $id)->delete();

        // Xóa người dùng
        $khachHang->delete();

        return redirect()->route('admin.khachhang.index')->with('success', 'Đã xóa khách hàng thành công.');
    }
}
