<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\NhanVien;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class nhanvienController extends Controller
{
    public function index()
    {
        $nhanvien = NhanVien::all();
        $nhanvien = NhanVien::paginate(10); // Lấy 10 người dùng trên mỗi trang
        return view('admin.nhanvien', compact('nhanvien'));
    }
    //thêm


    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:100',
            'sdt' => ['required', 'regex:/^0[35789]\d{8}$/', 'unique:nhanvien,sdt'],
            'email' => [
                'required',
                'email',
                Rule::unique('nhanvien', 'email'), // Kiểm tra trong bảng nhanvien
                function ($attribute, $value, $fail) {
                    // Kiểm tra trong bảng nguoidung
                    if (DB::table('khachhang')->where('email', $value)->exists()) {
                        $fail('Email này đã tồn tại trong hệ thống người dùng.');
                    }
                },
            ],
            'chucvu' => 'required|string|max:100',
            'matkhau' => 'required|string|min:6',
        ]);

        // Tạo nhân viên mới
        $nhanvien = new NhanVien();
        $nhanvien->ten = $request->input('ten');
        $nhanvien->sdt = $request->input('sdt');
        $nhanvien->chucvu = $request->input('chucvu');
        $nhanvien->email = $request->input('email');
        $nhanvien->matkhau = Hash::make($request->input('matkhau'));

        $nhanvien->save();

        return redirect()->back()->with('success', 'Nhân viên đã được thêm thành công!');
    }



    //xóa
    public function destroy($id)
    {
        $nhanvien = NhanVien::findOrFail($id);


        $nhanvien->delete();
        return redirect('admin/nhanvien')->with('success', 'Xóa thành công.');
    }

    public function update(Request $request, $idnv)
    {
        // Xác thực dữ liệu
        $request->validate([
            'ten' => 'required|string|max:100',
            'sdt' => ['required', 'regex:/^0[35789]\d{8}$/'],
            'email' => [
                'required',
                'email',
                Rule::unique('nhanvien', 'email')->ignore($idnv, 'idnv'), // Kiểm tra email không trùng với bảng nhanvien
                function ($attribute, $value, $fail) {
                    // Kiểm tra trong bảng khachhang
                    if (DB::table('khachhang')->where('email', $value)->exists()) {
                        $fail('Email này đã tồn tại trong hệ thống khách hàng.');
                    }
                },
            ],
            'matkhau' => 'nullable|string|min:6', // Không bắt buộc
            'chucvu' => 'required|string|max:100',
        ]);

        // Tìm nhân viên
        $nhanvien = NhanVien::findOrFail($idnv);

        // Cập nhật thông tin nhân viên
        $nhanvien->ten = $request->input('ten');
        $nhanvien->sdt = $request->input('sdt');
        $nhanvien->email = $request->input('email');
        $nhanvien->chucvu = $request->input('chucvu');

       

        $nhanvien->save();

        return redirect()->back()->with('success', 'Thông tin nhân viên đã được cập nhật thành công.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query'); // Lấy từ khóa tìm kiếm từ yêu cầu

        // Tìm kiếm người dùng theo tên hoặc email
        $nhanvien = NhanVien::where('ten', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->orWhere('sdt', 'LIKE', "%{$query}%")
            ->paginate(10); // Phân trang kết quả tìm kiếm

        return view('admin.nhanvien', compact('nhanvien')); // Trả về view với danh sách người dùng tìm được
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'idnv' => 'required|exists:nhanvien,idnv', // Kiểm tra ID nhân viên
            'matkhau' => 'required|string|min:6', // Kiểm tra mật khẩu mới
        ]);

        // Tìm nhân viên theo ID
        $nhanvien = NhanVien::findOrFail($request->idnv);

        // Cập nhật mật khẩu
        $nhanvien->matkhau = Hash::make($request->matkhau);
        $nhanvien->save();

        return redirect()->back()->with('success', 'Mật khẩu đã được thay đổi thành công!');
    }
}
