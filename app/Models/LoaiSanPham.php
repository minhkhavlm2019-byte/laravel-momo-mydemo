<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiSanPham extends Model
{
    use HasFactory;

    protected $table = 'loaisanpham';
    protected $primaryKey = 'LoaiID';  

    // Nếu không có timestamps (created_at, updated_at) thì tắt đi
    public $timestamps = false;
    protected $fillable = [
        'TenLoai',
        
    ];

    // Quan hệ: 1 loại có nhiều sản phẩm
    public function sanphams()
    {
        return $this->hasMany(SanPham::class, 'LoaiID');
    }
}
