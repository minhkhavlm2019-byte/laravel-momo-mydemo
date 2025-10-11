<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use Illuminate\Http\Request;

class DonHangAdminController extends Controller
{
    // Hiển thị danh sách đơn hàng
    public function index()
    {
        // Lấy tất cả đơn hàng kèm thông tin user
        $donHangs = DonHang::with('user')->orderBy('NgayDat', 'desc')->paginate(10);
        return view('admin.donhang.index', compact('donHangs'));
    }

    // Xem chi tiết 1 đơn hàng
    public function show($id)
    {
        $donHang = DonHang::with(['user', 'chiTietDonHangs.sanPham'])->findOrFail($id);
        return view('admin.donhang.show', compact('donHang'));
    }

    // Cập nhật trạng thái đơn hàng
    public function update(Request $request, $id)
    {
        $request->validate([
            'TrangThai' => 'required|string',
        ]);

        $donHang = DonHang::findOrFail($id);
        $donHang->TrangThai = $request->TrangThai;
        $donHang->save();

        return redirect()->route('admin.donhang.index')->with('success', 'Cập nhật đơn hàng thành công!');
    }

    // Xóa đơn hàng (nếu cần)
    public function destroy($id)
    {
        $donHang = DonHang::findOrFail($id);
        $donHang->delete();

        return redirect()->route('admin.donhang.index')->with('success', 'Đã xóa đơn hàng!');
    }
}
