<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SanPham;
use App\Models\LoaiSanPham;
use App\Models\ThuongHieu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SanPhamController extends Controller
{
    // 🔹 Danh sách sản phẩm
    public function index(Request $request)
    {
        $query = SanPham::with(['loai', 'thuonghieu']);

        // Bộ lọc
        if ($request->keyword) {
            $query->where('TenSanPham', 'like', '%' . $request->keyword . '%');
        }

        if ($request->loai) {
            $query->where('LoaiID', $request->loai);
        }

        if ($request->thuonghieu) {
            $query->where('ThuongHieuID', $request->thuonghieu);
        }

        $dsSanPham = $query->orderByDesc('SanPhamID')->paginate(10);
        $dsLoai = LoaiSanPham::all();
        $dsThuongHieu = ThuongHieu::all();

        return view('admin.sanpham.index', compact('dsSanPham', 'dsLoai', 'dsThuongHieu'));
    }

    // 🔹 Form thêm mới
    public function create()
    {
        $dsLoai = LoaiSanPham::all();
        $dsThuongHieu = ThuongHieu::all();
        return view('admin.sanpham.create', compact('dsLoai', 'dsThuongHieu'));
    }

    // 🔹 Lưu sản phẩm mới
    public function store(Request $request)
    {
        $request->validate([
            'TenSanPham' => 'required|string|max:255',
            'Gia' => 'required|numeric|min:0',
            'SoLuongTon' => 'required|integer|min:0',
            'ThuongHieuID' => 'required|exists:thuonghieu,ThuongHieuID',
            'LoaiID' => 'required|exists:loaisanpham,LoaiID',
            'TrangThai' => 'required|string',
        ]);

        $sanpham = new SanPham($request->except('HinhAnh'));

        // 🔸 Upload hình ảnh nếu có
        if ($request->hasFile('HinhAnh')) {
            $file = $request->file('HinhAnh');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/sanpham'), $filename);
            $sanpham->HinhAnh = $filename;
        }

        $sanpham->NgayNhap = now();
        $sanpham->save();

        return redirect()->route('admin.sanpham.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    // 🔹 Xem chi tiết
    public function show($id)
    {
        $sanpham = SanPham::with(['loai', 'thuonghieu'])->findOrFail($id);
        return view('admin.sanpham.show', compact('sanpham'));
    }

    // 🔹 Form chỉnh sửa
    public function edit($id)
    {
        $sanpham = SanPham::findOrFail($id);
        $dsLoai = LoaiSanPham::all();
        $dsThuongHieu = ThuongHieu::all();

        return view('admin.sanpham.edit', compact('sanpham', 'dsLoai', 'dsThuongHieu'));
    }

    // 🔹 Cập nhật sản phẩm
    public function update(Request $request, $id)
    {
        $request->validate([
            'TenSanPham' => 'required|string|max:255',
            'Gia' => 'required|numeric|min:0',
            'SoLuongTon' => 'required|integer|min:0',
            'ThuongHieuID' => 'required|exists:thuonghieu,ThuongHieuID',
            'LoaiID' => 'required|exists:loaisanpham,LoaiID',
            'TrangThai' => 'required|string',
        ]);

        $sanpham = SanPham::findOrFail($id);
        $sanpham->fill($request->except('HinhAnh'));

        // 🔸 Cập nhật hình ảnh nếu có
        if ($request->hasFile('HinhAnh')) {
            // Xóa ảnh cũ
            if ($sanpham->HinhAnh && File::exists(public_path('images/sanpham/' . $sanpham->HinhAnh))) {
                File::delete(public_path('images/sanpham/' . $sanpham->HinhAnh));
            }

            // Lưu ảnh mới
            $file = $request->file('HinhAnh');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/sanpham'), $filename);
            $sanpham->HinhAnh = $filename;
        }

        $sanpham->save();

        return redirect()->route('admin.sanpham.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    // 🔹 Xóa sản phẩm
    public function destroy($id)
    {
        $sanpham = SanPham::findOrFail($id);

        // Xóa ảnh
        if ($sanpham->HinhAnh && File::exists(public_path('images/sanpham/' . $sanpham->HinhAnh))) {
            File::delete(public_path('images/sanpham/' . $sanpham->HinhAnh));
        }

        $sanpham->delete();
        return redirect()->route('admin.sanpham.index')->with('success', 'Đã xóa sản phẩm!');
    }
}
