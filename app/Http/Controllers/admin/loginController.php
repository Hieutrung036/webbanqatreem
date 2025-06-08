<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class loginController extends Controller
{
    public function dangxuat(Request $request)
    {
        // Đăng xuất admin
        Auth::guard('nhanvien')->logout();

        // Xóa toàn bộ session
        $request->session()->invalidate();

        // Tạo lại CSRF token để đảm bảo bảo mật
        $request->session()->regenerateToken();

        // Chuyển hướng đến trang đăng nhập admin
        return redirect()->route('admin.login'); // Nếu bạn đã đặt tên route là 'client.trangchu'
    }

    public function showLoginForm()
    {
        return view('admin.login'); // View trang đăng nhập
    }

    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    // Kiểm tra login cho nhân viên
    $nhanvien = NhanVien::where('email', $request->email)->first();
    if ($nhanvien && Hash::check($request->password, $nhanvien->matkhau)) {
        // Đăng nhập nhân viên
        Auth::guard('nhanvien')->login($nhanvien);
        return redirect()->route('admin.trangchu'); // Đến trang admin cho nhân viên
    }

    // Kiểm tra login cho admin
    $admin = Admin::where('email', $request->email)->first();
    if ($admin && Hash::check($request->password, $admin->matkhau)) {
        // Đăng nhập admin
        Auth::guard('admin')->login($admin);
        return redirect()->route('admin.trangchu'); // Đến trang admin cho admin
    }

    // Nếu không tìm thấy người dùng
    return redirect()->route('admin.login')->withErrors(['msg' => 'Thông tin đăng nhập không chính xác.']);
}

}
