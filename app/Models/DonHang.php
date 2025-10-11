<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class DonHang extends Model
{
    protected $table = 'DonHang';
    protected $primaryKey = 'DonHangID';
    public $timestamps = false;
    protected $fillable = [
        'UserID',
        'NgayDat',
        'TongTien',
        'PhuongThucThanhToan',
        'TrangThai'
    ];
    public function chiTiet()
    {
        return $this->hasMany(ChiTietDonHang::class, 'DonHangID');
    }

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'UserID');
    }
    public function user()
    {
        return $this->belongsTo(\App\Models\NguoiDung::class, 'UserID');
    }

    public function chiTietDonHangs()
    {
        return $this->hasMany(\App\Models\ChiTietDonHang::class, 'DonHangID');
    }

}

