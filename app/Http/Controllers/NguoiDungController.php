<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NguoiDung;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class NguoiDungController extends Controller
{
   // Trang hồ sơ người dùng
    public function profile()
    {
        $user = Auth::user(); // truyền user hiện tại sang view
        return view('user.profile', compact('user'));
    }
    
}