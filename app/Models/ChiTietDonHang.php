<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietDonHang extends Model
{
    //
    protected $table = 'ChiTietDonHang';
    protected $primaryKey = 'ChiTietID';
    public $timestamps = false;
    protected $fillable = ['DonHangID', 'SanPhamID', 'SoLuong', 'GiaLucMua'];

    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'DonHangID');
    }

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'SanPhamID');
    }
}
