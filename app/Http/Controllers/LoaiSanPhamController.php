<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\LoaiSanPham;

class LoaiSanPhamController extends Controller
{
    //
    public function index(){
        $dsLoaiSanPham=LoaiSanPham::all();
        return view('danhmuc.index',compact('dsLoaiSanPham'));
    }
}
