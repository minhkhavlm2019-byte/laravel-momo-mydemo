<?php

namespace App\Http\Controllers;

use App\Models\ThuongHieu;

class ThuongHieuController extends Controller
{
    public function index()
    {
        $dsThuongHieu = ThuongHieu::all(); // Lấy tất cả bản ghi
        return view('thuonghieu.index', compact('dsThuongHieu'));
    }
}
