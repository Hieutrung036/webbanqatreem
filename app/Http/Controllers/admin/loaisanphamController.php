<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DanhMucSanPham;
use Illuminate\Http\Request;
use App\Models\LoaiSanPham;
use App\Models\LoaiTinTuc;
use App\Models\Sanpham;
use Illuminate\Validation\Rule; // Đảm bảo import Rule ở đây

class loaisanphamController extends Controller
{
    public function index()
    {
        $loaisanpham = LoaiSanPham::all();
        $danhmucsanpham = DanhMucSanPham::all();

        $loaisanpham = LoaiSanPham::paginate(10); // Lấy 10 người dùng trên mỗi trang

        return view('admin.loaisanpham', compact('loaisanpham', 'danhmucsanpham'));
    }

    public function store(Request $request)
{
    $request->validate([
        'ten' => [
            'required',
            'string',
            'max:100',
            Rule::unique('loaisanpham')->where(function ($query) use ($request) {
                return $query->where('iddm', $request->iddm); // Kiểm tra uniqueness theo iddm
            }),
        ],
        'iddm' => 'required|exists:danhmucsanpham,iddm', // Kiểm tra iddm tồn tại
    ], [
        'ten.unique' => 'Tên loại sản phẩm đã tồn tại trong danh mục này.', // Tùy chỉnh thông báo lỗi
        'iddm.exists' => 'Danh mục sản phẩm không hợp lệ.', // Tùy chỉnh thông báo lỗi
    ]);

    // Tạo loại sản phẩm mới
    $loaisanpham = new LoaiSanPham();
    $loaisanpham->ten = $request->input('ten');
    $loaisanpham->iddm = $request->input('iddm'); // Gán iddm vào cột tương ứng

    // Lưu vào cơ sở dữ liệu
    $loaisanpham->save();

    // Quay lại trang trước với thông báo thành công
    return redirect()->back()->with('success', 'Loại sản phẩm đã được thêm thành công!');
}



    //xóa

    public function destroy($idlsp)
    {
        // Tìm bản ghi tin tức
        $loaisanpham = LoaiSanPham::find($idlsp);


        $loaisanpham->delete();

        return redirect()->back()->with('success', 'Loại sản phẩm đã được xóa thành công!');
    }
    public function update(Request $request, $idlsp)
{
    // Xác thực dữ liệu
    $request->validate([
        'ten' => [
            'required', 
            'string',
            'max:100',
            Rule::unique('loaisanpham')
                ->where(function ($query) use ($request) {
                    return $query->where('iddm', $request->iddm); // Kiểm tra uniqueness theo iddm
                })
                ->ignore($idlsp, 'idlsp'), // Bỏ qua bản ghi hiện tại
        ],
        'iddm' => 'required|exists:danhmucsanpham,iddm', // Đảm bảo iddm hợp lệ
    ], [
        'ten.unique' => 'Tên loại sản phẩm đã tồn tại trong danh mục này.', // Thông báo lỗi tùy chỉnh
        'iddm.exists' => 'Danh mục sản phẩm không hợp lệ.', // Thông báo lỗi tùy chỉnh
    ]);

    // Tìm loại sản phẩm
    $loaisanpham = LoaiSanPham::findOrFail($idlsp);

    // Cập nhật thông tin
    $loaisanpham->ten = $request->input('ten');
    $loaisanpham->iddm = $request->input('iddm'); // Gán danh mục mới

    // Lưu thay đổi vào cơ sở dữ liệu
    $loaisanpham->save();

    return redirect()->back()->with('success', 'Thông tin loại sản phẩm đã được cập nhật thành công.');
}


    public function search(Request $request)
    {
        $query = $request->input('query'); // Lấy từ khóa tìm kiếm từ yêu cầu
        $danhmucsanpham = DanhMucSanPham::all(); // Lấy tất cả người dùng từ cơ sở dữ liệu
        // Tìm kiếm người dùng theo tên hoặc email
        $loaisanpham = LoaiSanPham::where('ten', 'LIKE', "%{$query}%")

            ->paginate(10); // Phân trang kết quả tìm kiếm

        return view('admin.loaisanpham', compact('loaisanpham','danhmucsanpham')); // Trả về view với danh sách người dùng tìm được
    }
}
