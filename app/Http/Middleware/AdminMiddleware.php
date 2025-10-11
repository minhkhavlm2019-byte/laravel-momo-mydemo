<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Nếu người dùng chưa đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập trước!');
        }

        // Nếu người dùng là Admin → cho qua
        if (Auth::user()->VaiTro === 'Admin') {
            return $next($request);
        }

        // Nếu không phải admin
        return redirect('/')->with('error', 'Bạn không có quyền truy cập khu vực quản trị!');
    }
}
