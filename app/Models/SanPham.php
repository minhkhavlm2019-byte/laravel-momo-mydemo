<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    protected $table = 'sanpham'; // Tên bảng
    protected $primaryKey = 'SanPhamID'; // Khóa chính

    // Cho phép fill dữ liệu tự động
    protected $fillable = [
        'TenSanPham', 'MoTa', 'Gia', 'SoLuongTon', 'ThuongHieuID', 'LoaiID', 'HinhAnh', 'NgayNhap', 'TrangThai'
    ];

    // Quan hệ: 1 sản phẩm thuộc 1 thương hiệu
    public function thuongHieu() {
        return $this->belongsTo(ThuongHieu::class, 'ThuongHieuID');
    }

    // Quan hệ: 1 sản phẩm thuộc 1 loại
    public function loai() {
        return $this->belongsTo(LoaiSanPham::class, 'LoaiID');
    }
    public function loaiSanPham()
    {
        return $this->belongsTo(LoaiSanPham::class, 'LoaiID', 'LoaiID');
    }
}
