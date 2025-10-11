<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;   
use App\Models\NguoiDung;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\SendOtpMail;
class AuthController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('auth.login');
    }
 // Xử lý đăng nhập
    public function login(Request $request)
    {
        // Lấy thông tin đăng nhập
        $credentials = [
            'Email' => $request->email,     // Cột Email trong DB
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Kiểm tra vai trò
            if ($user->VaiTro === 'Admin') {
                return redirect()->route('admin.dashboard'); // Trang quản trị
            } else {
                return redirect()->route('sanpham.index');   // Trang sản phẩm cho khách
            }
        }

        // Nếu thất bại
        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng',
        ]);
    }

    // Đăng xuất
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
    // Hiển thị form đăng ký
    public function showRegisterForm()
    {
        return view('auth.register');
    }
/*
    // Xử lý đăng ký
    public function register(Request $request)
    {
        $request->validate([
            'HoTen' => 'required|string|max:100',
            'Email' => 'required|email|unique:NguoiDung,Email',
            'MatKhau' => 'required|min:6|confirmed',
            'SoDienThoai' => 'nullable|string|max:20',
            'DiaChi' => 'nullable|string|max:200',
        ]);

        $user = NguoiDung::create([
            'HoTen' => $request->HoTen,
            'Email' => $request->Email,
            'MatKhau' => Hash::make($request->MatKhau), // Băm mật khẩu
            'SoDienThoai' => $request->SoDienThoai,
            'DiaChi' => $request->DiaChi,
            'VaiTro' => 'KhachHang', // mặc định
            'NgayDangKy' => now(),
        ]);

        return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    } */
    // ✅ Xử lý đăng ký
    public function register(Request $request) {
        $request->validate([
            'HoTen' => 'required|string|max:100',
            'Email' => 'required|email|unique:NguoiDung,Email',
            'MatKhau' => 'required|min:6|confirmed',
        ]);

        $otp = rand(100000, 999999);

        $user = NguoiDung::create([
            'HoTen' => $request->HoTen,
            'Email' => $request->Email,
            'MatKhau' => Hash::make($request->MatKhau),
            'VaiTro' => 'KhachHang',
            'MaXacThuc' => $otp,
            'MaXacThucHetHan' => Carbon::now()->addMinutes(10),
        ]);

        Mail::to($user->Email)->send(new SendOtpMail($otp, 'Xác thực tài khoản MyStore'));

        return redirect()->route('otp.verify.form')->with('email', $user->Email);
    }
     // ✅ Form nhập OTP xác thực
    public function showVerifyOtpForm() {
        return view('auth.verify-otp');
    }

    // ✅ Xử lý OTP đăng ký
    public function verifyOtp(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric'
        ]);

        $user = NguoiDung::where('Email', $request->email)->first();

        if (!$user || $user->maxacthuc !== $request->otp)
            return back()->withErrors(['otp' => 'Mã xác thực không đúng.']);

        if (now()->gt($user->maxacthuchethan))
            return back()->withErrors(['otp' => 'Mã đã hết hạn, vui lòng gửi lại.']);

        $user->maxacthuc = null;
        $user->maxacthuchethan = null;
        $user->save();

        return redirect()->route('login')->with('success', 'Xác thực thành công, bạn có thể đăng nhập!');
    }

    // ✅ Quên mật khẩu: gửi OTP
    public function showForgotForm() {
        return view('auth.forgot');
    }

    public function sendResetOtp(Request $request) {
        $request->validate(['email' => 'required|email']);
        $user = NguoiDung::where('Email', $request->email)->first();

        if (!$user)
            return back()->withErrors(['email' => 'Email không tồn tại.']);

        $otp = rand(100000, 999999);
        $user->maxacthuc = $otp;
        $user->maxacthuchethan = now()->addMinutes(10);
        $user->save();

        Mail::to($user->Email)->send(new SendOtpMail($otp, 'Mã OTP khôi phục mật khẩu MyStore'));

        return view('auth.reset', ['email' => $user->Email]);
    }

    // ✅ Xử lý đặt lại mật khẩu qua OTP
    public function resetPassword(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = NguoiDung::where('Email', $request->email)->first();

        if (!$user || $user->maxacthuc !== $request->otp)
            return back()->withErrors(['otp' => 'Mã OTP không đúng.']);

        if (now()->gt($user->maxacthuchethan))
            return back()->withErrors(['otp' => 'Mã OTP đã hết hạn.']);

        $user->MatKhau = Hash::make($request->password);
        $user->maxacthuc = null;
        $user->maxacthuchethan = null;
        $user->save();

        return redirect()->route('login')->with('success', 'Đặt lại mật khẩu thành công!');
    }
}
