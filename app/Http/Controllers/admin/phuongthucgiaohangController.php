<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PhuongThucGiaoHang;
use Illuminate\Http\Request;

class phuongthucgiaohangController extends Controller
{
    public function index()
    {
        $phuongthucgiaohang = PhuongThucGiaoHang::all();
        $phuongthucgiaohang = PhuongThucGiaoHang::paginate(10);
        return view('admin.phuongthucgiaohang', compact('phuongthucgiaohang'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:100|unique:phuongthucgiaohang,ten',
            'phigiaohang' => 'required|integer|min:0',
            'ngaydukien' => 'required|integer|min:0',
            'mota' => 'required|string|max:255',
        ], [
            'ten.unique' => 'Trùng phương thức.', // Tùy chỉnh thông báo lỗi
        ]);


        // Tạo loại sản phẩm mới
        $phuongthucgiaohang = new PhuongThucGiaoHang();
        $phuongthucgiaohang->ten = $request->input('ten');
        $phuongthucgiaohang->phigiaohang = $request->input('phigiaohang');
        $phuongthucgiaohang->ngaydukien = $request->input('ngaydukien');
        $phuongthucgiaohang->mota = $request->input('mota');

        // Lưu vào cơ sở dữ liệu
        $phuongthucgiaohang->save();

        // Quay lại trang trước với thông báo thành công
        return redirect()->back()->with('success', 'Phương thức giao hàng đã được thêm thành công!');
    }

    public function destroy($idptgh)
    {
        $phuongthucgiaohang = PhuongThucGiaoHang::find($idptgh);

        if ($phuongthucgiaohang) {
            $phuongthucgiaohang->delete();
            return redirect()->back()->with('success', 'Phương thức giao hàng đã được xóa thành công!');
        }
        return redirect()->back();
    }

    public function update(Request $request, $idpttt)
    {
        // Xác thực dữ liệu
        $request->validate([
            'ten' => 'required|string|max:100|unique:phuongthucgiaohang,ten',
            'phigiaohang' => 'required|integer|min:0',
            'ngaydukien' => 'required|integer|min:0',
            'mota' => 'required|string|max:255',
        ], [
            'ten.unique' => 'Trùng phương thức.', // Tùy chỉnh thông báo lỗi
        ]);
        // Tìm loại sản phẩm
        $phuongthucgiaohang = PhuongThucGiaoHang::findOrFail($idpttt);

        // Cập nhật thông tin
        $phuongthucgiaohang->ten = $request->input('ten');
        $phuongthucgiaohang->phigiaohang = $request->input('phigiaohang');
        $phuongthucgiaohang->ngaydukien = $request->input('ngaydukien');
        $phuongthucgiaohang->mota = $request->input('mota');


        // Lưu thay đổi vào cơ sở dữ liệu
        $phuongthucgiaohang->save();

        return redirect()->back()->with('success', 'Thông tin phương thức giao hàng đã được cập nhật thành công.');
    }
    public function search(Request $request)
    {
        $query = $request->input('query'); // Lấy từ khóa tìm kiếm từ yêu cầu

        // Tìm kiếm người dùng theo tên hoặc email
        $phuongthucgiaohang = PhuongThucGiaoHang::where('ten', 'LIKE', "%{$query}%")
            ->orWhere('phigiaohang', 'LIKE', "%{$query}%")
            ->orWhere('ngaydukien', 'LIKE', "%{$query}%")
            ->paginate(10); // Phân trang kết quả tìm kiếm

        return view('admin.phuongthucgiaohang', compact('phuongthucgiaohang')); // Trả về view với danh sách người dùng tìm được
    }
}
