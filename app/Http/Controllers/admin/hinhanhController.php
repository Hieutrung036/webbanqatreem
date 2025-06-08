<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ChiTietSanPham;
use App\Models\HinhAnh;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class hinhanhController extends Controller
{
    public function store(Request $request, $idsp)
    {
        // Kiểm tra xem sản phẩm có tồn tại hay không
        $sanpham = SanPham::find($idsp);
        if (!$sanpham) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại.');
        }

        $request->validate([
            'hinhchinh' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $file = $request->file('hinhchinh');
            $ext = $file->extension();
            $fileName = time() . '-' . 'hinhchinh.' . $ext;
            $file->move(public_path('uploads/sanpham'), $fileName); // Đường dẫn lưu

            // Lưu hình ảnh vào database
            HinhAnh::create([
                'duongdan' => $fileName,
                'idsp' => $idsp,
            ]);

            return redirect()->back()->with('success', 'Thêm hình chính thành công.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi trong quá trình thêm hình: ' . $e->getMessage());
        }
    }
    public function update(Request $request, $id)
    {
        // Tìm hình ảnh cần cập nhật
        $hinhanh = HinhAnh::findOrFail($id);

        // Kiểm tra xem request có chứa file hình ảnh mới hay không
        if ($request->hasFile('hinhchinh')) {
            // Đường dẫn file cũ
            $hinhcu = public_path('uploads/sanpham/' . $hinhanh->duongdan);

            // Xóa file cũ nếu tồn tại
            if (file_exists($hinhcu)) {
                @unlink($hinhcu);
            }

            $file = $request->file('hinhchinh');
            $ext = $file->getClientOriginalExtension();

            // Tạo tên file mới với timestamp để tránh trùng lặp
            $fileName = time() . '-' . 'hinhchinh.' . $ext;

            // Di chuyển file hình ảnh mới vào thư mục uploads
            $file->move(public_path('uploads/sanpham'), $fileName);

            // Cập nhật đường dẫn hình ảnh mới vào model
            $hinhanh->duongdan = $fileName;
        }

        // Lưu thay đổi
        $hinhanh->save();

        // Chuyển hướng người dùng về trang danh sách hình ảnh với thông báo thành công
        return redirect()->back()->with('success', 'Cập nhật thành công.');
    }

    public function destroy($id)
    {
        $hinhanh = HinhAnh::findOrFail($id);

        // Đường dẫn đến file hình ảnh
        $hinhPath = public_path('uploads/sanpham/' . $hinhanh->duongdan);

        // Xóa file hình ảnh khỏi thư mục uploads
        if (file_exists($hinhPath)) {
            @unlink($hinhPath);
        }

        // Xóa bản ghi trong cơ sở dữ liệu
        $hinhanh->delete();

        return redirect()->back()->with('success', 'Xóa hình ảnh thành công!');
    }

    

   
}
