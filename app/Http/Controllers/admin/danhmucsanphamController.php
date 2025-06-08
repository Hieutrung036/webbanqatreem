<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DanhMucSanPham;
use Illuminate\Validation\Rule; // Đảm bảo import Rule ở đây
use Illuminate\Http\Request;

class danhmucsanphamController extends Controller
{
    public function index()
    {
        $danhmucsanpham = DanhMucSanPham::all();
        $danhmucsanpham = DanhMucSanPham::paginate(10); // Lấy 10 người dùng trên mỗi trang
        return view('admin.danhmucsanpham', compact('danhmucsanpham'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:100|unique:danhmucsanpham,ten',
        ], [
            'ten.unique' => 'Trùng danh mục.', // Tùy chỉnh thông báo lỗi
        ]);


        // Tạo loại sản phẩm mới
        $danhmucsanpham = new DanhMucSanPham();
        $danhmucsanpham->ten = $request->input('ten');
        $danhmucsanpham->gioitinh = $request->input('gioitinh');

        // Lưu vào cơ sở dữ liệu
        $danhmucsanpham->save();

        // Quay lại trang trước với thông báo thành công
        return redirect()->back()->with('success', 'Danh mục sản phẩm đã được thêm thành công!');
    }

    public function destroy($iddm)
    {
        $danhmucsanpham = DanhMucSanPham::find($iddm);
        $danhmucsanpham->delete();
        return redirect()->back()->with('success', 'Danh mục sản phẩm đã được xóa thành công!');
    }
    
    public function update(Request $request, $iddm)
    {
        // Xác thực dữ liệu
       $request->validate([
            'ten' => [
                'required', // Thêm điều kiện bắt buộc
                'string',
                'max:100',
                Rule::unique('danhmucsanpham')->where(function ($query) use ($request) {
                    return $query->where('gioitinh', $request->gioitinh); // Kiểm tra với gioitinh tương ứng
                })->ignore($iddm, 'iddm'), // Bỏ qua bản ghi hiện tại dựa trên khóa chính
            ],
            
            'gioitinh' => 'required|in:0,1', // Bắt buộc
        ]);
        // Tìm loại sản phẩm
        $danhmucsanpham = DanhMucSanPham::findOrFail($iddm);

        // Cập nhật thông tin
        $danhmucsanpham->ten = $request->input('ten');
        $danhmucsanpham->gioitinh = $request->input('gioitinh');
        // Lưu thay đổi vào cơ sở dữ liệu
        $danhmucsanpham->save();

        return redirect()->back()->with('success', 'Thông tin danh mục đã được cập nhật thành công.');
    }
    public function search(Request $request)
    {
        $query = $request->input('query'); // Lấy từ khóa tìm kiếm từ yêu cầu

        // Tìm kiếm người dùng theo tên hoặc email
        $danhmucsanpham = danhmucsanpham::where('ten', 'LIKE', "%{$query}%")
            ->paginate(10); // Phân trang kết quả tìm kiếm

        return view('admin.danhmucsanpham', compact('danhmucsanpham')); // Trả về view với danh sách người dùng tìm được
    }
}
