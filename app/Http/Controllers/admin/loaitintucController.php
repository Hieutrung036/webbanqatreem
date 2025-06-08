<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DanhGia;
use App\Models\HinhAnh;
use App\Models\LoaiSanPham;
use App\Models\LoaiSanPhamCon;
use App\Models\LoaiTinTuc;
use App\Models\PhanHoi;
use App\Models\Sanpham;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Đảm bảo import Rule ở đây

class loaitintucController extends Controller
{
    public function index()
    {
        $loaitintuc = LoaiTinTuc::all();
        $loaitintuc = LoaiTinTuc::withCount('tinTuc')->paginate(10); // Phân trang với 10 mục mỗi trang
        return view('admin.loaitintuc', compact('loaitintuc'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:100|unique:loaitintuc,ten',
            'mota' => 'required|string|max:255',
            'soluongtintuc' => 'nullable|integer|min:0',
        ], [
            'ten.unique' => 'Trùng loại tin tức.', // Tùy chỉnh thông báo lỗi
        ]);


        // Tạo loại sản phẩm mới
        $loaitintuc = new LoaiTinTuc();
        $loaitintuc->ten = $request->input('ten');
        $loaitintuc->mota = $request->input('mota');
        $loaitintuc->soluongtintuc = $request->input('soluongsanpham', 0);

        // Lưu vào cơ sở dữ liệu
        $loaitintuc->save();

        // Quay lại trang trước với thông báo thành công
        return redirect()->back()->with('success', 'Loại tin tức đã được thêm thành công!');
    }

    public function destroy($id)
    {
        // Tìm loại sản phẩm
        $loaisanpham = LoaiSanPham::findOrFail($id);

        // Tìm tất cả sản phẩm thuộc loại sản phẩm này
        $sanphams = SanPham::where('idlsp', $id)->with('chitietsanpham.hinhanh')->get();

        // Lặp qua từng sản phẩm
        foreach ($sanphams as $sanpham) {
            // Xóa tất cả hình ảnh liên quan đến từng chi tiết sản phẩm
            foreach ($sanpham->chitietsanpham as $chitietsanpham) {
                HinhAnh::where('idctsp', $chitietsanpham->idctsp)->delete();
                $chitietsanpham->delete();
            }
            $sanpham->delete();
        }

        // Xóa loại sản phẩm
        $loaisanpham->delete();

        // Chuyển hướng với thông báo thành công
        return redirect('admin/loaisanpham')->with('success', 'Xóa thành công');
    }



    public function update(Request $request, $idltt)
    {
        // Xác thực dữ liệu
        $request->validate([
            'ten' => [
                'required',
                'string',
                'max:100',
                Rule::unique('loaitintuc')->ignore($idltt, 'idltt'), // Specify 'idm' as the ID column
            ],
            'mota' => 'required|string|max:255',
        ], [
            'ten.unique' => 'Trùng loại tin tức.', // Tùy chỉnh thông báo lỗi
        ]);
        // Tìm loại sản phẩm
        $loaitintuc = LoaiTinTuc::findOrFail($idltt);

        // Cập nhật thông tin
        $loaitintuc->ten = $request->input('ten');
        $loaitintuc->mota = $request->input('mota');



        // Lưu thay đổi vào cơ sở dữ liệu
        $loaitintuc->save();

        return redirect()->back()->with('success', 'Loại tin tức đã được cập nhật thành công.');
    }
    public function search(Request $request)
    {
        $query = $request->input('query'); // Lấy từ khóa tìm kiếm từ yêu cầu

        // Tìm kiếm người dùng theo tên hoặc email
        $loaitintuc = LoaiTinTuc::where('ten', 'LIKE', "%{$query}%")
            ->paginate(10); // Phân trang kết quả tìm kiếm

        return view('admin.loaitintuc', compact('loaitintuc')); // Trả về view với danh sách người dùng tìm được
    }
}
