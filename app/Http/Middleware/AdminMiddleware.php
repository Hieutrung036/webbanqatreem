<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('nhanvien')->check()) {
            return $next($request);
        }

        // Kiểm tra nếu là admin đã đăng nhập
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // Nếu không phải nhân viên hoặc admin, chuyển hướng về login
        return redirect()->route('admin.login')->withErrors(['msg' => 'Bạn cần đăng nhập để vào trang quản trị.']);
    }
}
