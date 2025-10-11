<?php

use Illuminate\Support\Facades\Route;

// ========================= TRANG CHỦ =========================
use App\Http\Controllers\HomeController;
Route::get('/', [HomeController::class, 'index'])->name('home');


// ========================= SẢN PHẨM =========================
use App\Http\Controllers\SanPhamController;
Route::get('/sanpham', [SanPhamController::class, 'index'])->name('sanpham.index');
Route::get('/sanpham/{id}', [SanPhamController::class, 'show'])->name('sanpham.show');


// ========================= AUTH =========================
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
// Xác thực OTP
Route::get('/verify-otp', [AuthController::class, 'showVerifyOtpForm'])->name('otp.verify.form');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.verify.submit');

// Quên mật khẩu
Route::get('/forgot', [AuthController::class, 'showForgotForm'])->name('password.forgot');
Route::post('/forgot', [AuthController::class, 'sendResetOtp'])->name('password.sendOtp');
Route::post('/reset', [AuthController::class, 'resetPassword'])->name('password.reset');

// ========================= PROFILE NGƯỜI DÙNG =========================
use App\Http\Controllers\UserController;
Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('user.updateProfile');
    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('user.updatePassword');
});


// ========================= GIỎ HÀNG & ĐƠN HÀNG (CUSTOMER) =========================
use App\Http\Controllers\GioHangController;
use App\Http\Controllers\DonHangController;
use App\Http\Controllers\PaymentController;

Route::middleware(['auth', 'customer'])->group(function () {
    // Giỏ hàng
    Route::get('/giohang', [GioHangController::class, 'index'])->name('giohang.index');
    Route::post('/giohang/add/{id}', [GioHangController::class, 'add'])->name('giohang.add');
    Route::post('/giohang/tang/{id}', [GioHangController::class, 'tang'])->name('giohang.tang');
    Route::post('/giohang/giam/{id}', [GioHangController::class, 'giam'])->name('giohang.giam');
    Route::delete('/giohang/xoa/{id}', [GioHangController::class, 'xoa'])->name('giohang.xoa');
    Route::delete('/giohang/xoa-toan-bo', [GioHangController::class, 'xoaToanBo'])->name('giohang.xoaToanBo');

    // Đơn hàng
    Route::get('/donhang', [DonHangController::class, 'index'])->name('donhang.index');
//    Route::post('/donhang', [DonHangController::class, 'store'])->name('donhang.store');
//    Route::post('/donhang', [DonHangController::class, 'store'])->name('donhang.store');

    Route::post('/donhang/store', [DonHangController::class, 'store'])->name('donhang.store');

// Thanh toán
Route::get('/payment/checkout/{DonHangID}', [PaymentController::class, 'checkout'])->name('payment.checkout');
Route::post('/payment/momo', [PaymentController::class, 'momo'])->name('payment.momo');
Route::post('/payment/cod', [PaymentController::class, 'cod'])->name('payment.cod');
Route::get('/payment/return', [PaymentController::class, 'return'])->name('payment.return');
Route::post('/payment/notify', [PaymentController::class, 'notify'])->name('payment.notify');
});


// ========================= ADMIN AREA =========================
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KhachHangController;
use App\Http\Controllers\Admin\DonHangAdminController;
use App\Http\Controllers\Admin\SanPhamController as AdminSanPhamController;

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Quản lý khách hàng
        Route::get('/khachhang', [KhachHangController::class, 'index'])->name('khachhang.index');
        Route::get('/khachhang/{id}', [KhachHangController::class, 'show'])->name('khachhang.show');
        Route::delete('/khachhang/{id}', [KhachHangController::class, 'destroy'])->name('khachhang.destroy');

        // Quản lý đơn hàng
        Route::get('/donhang', [DonHangAdminController::class, 'index'])->name('donhang.index');
        Route::get('/donhang/{id}', [DonHangAdminController::class, 'show'])->name('donhang.show');
        Route::post('/donhang/{id}/update', [DonHangAdminController::class, 'update'])->name('donhang.update');
        Route::delete('/donhang/{id}', [DonHangAdminController::class, 'destroy'])->name('donhang.destroy');

        // Quản lý sản phẩm (CRUD)
        Route::resource('sanpham', AdminSanPhamController::class);
    });
