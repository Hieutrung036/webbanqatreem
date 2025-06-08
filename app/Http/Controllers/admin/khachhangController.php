<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KhachHang;
use App\Models\DiaChi;

use Illuminate\Support\Facades\Hash;

class khachhangController extends Controller
{
    //hiển thị giao diện
    public function index()
    {
        $khachhang = KhachHang::all();
        $khachhang = KhachHang::paginate(10); // Lấy 10 người dùng trên mỗi trang
        return view('admin.khachhang', compact('khachhang'));
    }
    //thêm
    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'ten' => 'required|string|max:100',
            'sdt' => ['required', 'regex:/^0[35789]\d{8}$/'],
            'email' => 'required|email|unique:khachhang,email', // kiểm tra email đã tồn tại chưa
            'matkhau' => 'required|string|min:6',
        ]);

        // Tạo người dùng mới
        $khachhang = new KhachHang();
        $khachhang->ten = $request->input('ten');
        $khachhang->sdt = $request->input('sdt');
        $khachhang->email = $request->input('email');
        $khachhang->matkhau = Hash::make($request->input('matkhau')); // Mã hóa mật khẩu
        $khachhang->block = 0; // Mã hóa mật khẩu

        // Lưu người dùng vào database
        $khachhang->save();

        // Quay lại trang trước hoặc về trang danh sách người dùng với thông báo thành công
        return redirect()->back()->with('success', 'Khách hàng đã được thêm thành công!');
    }
    //xóa

    public function block($id)
    {
        $khachhang = KhachHang::findOrFail($id);

        // Kiểm tra xem khách hàng đã bị khóa chưa
        if ($khachhang->block == 0) {
            // Chặn khách hàng
            $khachhang->block = 1;
            $khachhang->save();
            return redirect()->route('admin.khachhang')->with('success', 'Block thành công.');
        } else {
            // Bỏ chặn khách hàng
            $khachhang->block = 0;
            $khachhang->save();
            return redirect()->route('admin.khachhang')->with('success', 'Unblockthành công.');
        }
    }

    
    // Ví dụ trong LoginController
   
    

    public function update(Request $request, $idkh)
    {
        // Xác thực dữ liệu
        $request->validate([
            'ten' => 'required|string|max:100',
            // 'sdt' => ['required', 'regex:/^0[35789]\d{8}$/'],
            'sdt',
            'email' => 'required|email|unique:khachhang,email,' . $idkh . ',idkh', // Cập nhật ở đây
            'matkhau' => 'nullable|string|min:6', // Không bắt buộc
        ]);

        // Tìm người dùng
        $khachhang = KhachHang::findOrFail($idkh);

        // Cập nhật thông tin người dùng
        $khachhang->ten = $request->input('ten');
        $khachhang->sdt = $request->input('sdt');
        $khachhang->email = $request->input('email');

        // Cập nhật mật khẩu nếu có
        if ($request->filled('matkhau')) {
            $khachhang->matkhau = Hash::make($request->input('matkhau'));
        }

        $khachhang->save();

        return redirect()->back()->with('success', 'Thông tin khách hàng đã được cập nhật thành công.');
    }
    public function search(Request $request)
    {
        $query = $request->input('query'); // Lấy từ khóa tìm kiếm từ yêu cầu

        // Tìm kiếm người dùng theo tên hoặc email
        $khachhang = KhachHang::where('ten', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->orWhere('sdt', 'LIKE', "%{$query}%")
            ->paginate(10); // Phân trang kết quả tìm kiếm

        return view('admin.khachhang', compact('khachhang')); // Trả về view với danh sách người dùng tìm được
    }
}
