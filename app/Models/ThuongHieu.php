<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThuongHieu extends Model
{
    use HasFactory;

    protected $table = 'thuonghieu';
    protected $primaryKey = 'ThuongHieuID';  

    // Nếu không có timestamps (created_at, updated_at) thì tắt đi
    public $timestamps = false;

    protected $fillable = [
        'TenThuongHieu',
        'QuocGia',
    ];

    // Quan hệ: 1 thương hiệu có nhiều sản phẩm
    public function sanphams()
    {
        return $this->hasMany(SanPham::class, 'ThuongHieuID');
    }
}
