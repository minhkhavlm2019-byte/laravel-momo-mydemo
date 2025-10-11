<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // kế thừa để login/logout
use Illuminate\Notifications\Notifiable;

class NguoiDung extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'nguoidung'; // tên bảng

    protected $primaryKey = 'UserID'; // khóa chính

    public $timestamps = false; // vì bảng không có created_at, updated_at

    protected $fillable = [
        'HoTen',
        'Email',
        'MatKhau',
        'SoDienThoai',
        'DiaChi',
        'VaiTro',
        'NgayDangKy',

    ];

    protected $hidden = [
        'MatKhau',
    ];
    public function getAuthPassword()
    {
        return $this->MatKhau;
    }
    protected function casts(): array
    {
        return [
            'NgayDangKy' => 'datetime',
            'MatKhau' => 'hashed',
        ];
    }
    // Ví dụ: 1 user có nhiều đơn hàng
    public function donhangs()
    {
        return $this->hasMany(DonHang::class, 'UserID');
    }

}
