<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\NguoiDung;

class UserController extends Controller
{
    // Hiển thị trang profile
    public function profile()
    {
        return view('user.profile');
    }

    // Cập nhật thông tin cơ bản
    // Cập nhật thông tin
    public function updateProfile(Request $request)
    {
        $userId = Auth::id();

        $request->validate([
            'HoTen' => 'required|string|max:255',
            'SoDienThoai' => 'nullable|string|max:20',
            'DiaChi' => 'nullable|string|max:255',
        ]);

        DB::table('NguoiDung')
            ->where('UserID', $userId)
            ->update([
                'HoTen' => $request->HoTen,
                'SoDienThoai' => $request->SoDienThoai,
                'DiaChi' => $request->DiaChi,
            ]);

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }

    // Đổi mật khẩu
    // Đổi mật khẩu
    public function updatePassword(Request $request)
    {
        $userId = Auth::id();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = DB::table('NguoiDung')->where('UserID', $userId)->first();

        if (!$user) {
            return back()->with('error', 'Người dùng không tồn tại!');
        }

        if (!Hash::check($request->current_password, $user->MatKhau)) {
            return back()->with('error', 'Mật khẩu hiện tại không đúng!');
        }

        DB::table('NguoiDung')
            ->where('UserID', $userId)
            ->update([
                'MatKhau' => Hash::make($request->new_password),
            ]);

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }
}
