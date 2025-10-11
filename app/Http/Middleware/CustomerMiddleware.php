<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Nếu chưa đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiếp tục!');
        }

        // Nếu là khách hàng
        if (Auth::user()->VaiTro === 'KhachHang') {
            return $next($request);
        }

        // Nếu không phải khách hàng (ví dụ: Admin)
        return redirect('/')->with('error', 'Chỉ khách hàng mới có thể truy cập khu vực này!');
    }
}
