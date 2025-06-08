<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TrangThaiDonHang;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class trangthaidonhangController extends Controller
{
    public function index()
    {
        $trangthaidonhang = TrangThaiDonHang::all();
        $trangthaidonhang = TrangThaiDonHang::paginate(10); // Lấy 10 người dùng trên mỗi trang
        return view('admin.trangthaidonhang', compact('trangthaidonhang'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:100|unique:trangthaidonhang,ten',
            'mota' => 'required|string|max:255',
        ], [
            'ten.unique' => 'Trùng trạng thái.', // Tùy chỉnh thông báo lỗi
        ]);


        // Tạo loại sản phẩm mới
        $trangthaidonhang = new TrangThaiDonHang();
        $trangthaidonhang->ten = $request->input('ten');
        $trangthaidonhang->mota = $request->input('mota');

        // Lưu vào cơ sở dữ liệu
        $trangthaidonhang->save();

        // Quay lại trang trước với thông báo thành công
        return redirect()->back()->with('success', 'Trạng thái đã được thêm thành công!');
    }

    public function destroy($idttdh)
    {
        $trangthaidonhang = TrangThaiDonHang::find($idttdh);

        if ($trangthaidonhang) {
            $trangthaidonhang->delete();
            return redirect()->back()->with('success', 'Trạng thái đã được xóa thành công!');
        }

        return redirect()->back();
    }

    public function update(Request $request, $idttdh)
    {
        // Xác thực dữ liệu
        $request->validate([
            'ten' => [
                'required',
                'string',
                'max:100',
                Rule::unique('trangthaidonhang')->ignore($idttdh, 'idttdh'), // Specify 'idm' as the ID column
            ],
            'mota' => 'required|string|max:255',
        ], [
            'ten.unique' => 'Trùng trạng thái.', // Tùy chỉnh thông báo lỗi
        ]);
        // Tìm loại sản phẩm
        $trangthaidonhang = TrangThaiDonHang::findOrFail($idttdh);

        // Cập nhật thông tin
        $trangthaidonhang->ten = $request->input('ten');
        $trangthaidonhang->mota = $request->input('mota');



        // Lưu thay đổi vào cơ sở dữ liệu
        $trangthaidonhang->save();

        return redirect()->back()->with('success', 'Thông tin màu đã được cập nhật thành công.');
    }
    public function search(Request $request)
    {
        $query = $request->input('query'); // Lấy từ khóa tìm kiếm từ yêu cầu

        // Tìm kiếm người dùng theo tên hoặc email
        $trangthaidonhang = TrangThaiDonHang::where('ten', 'LIKE', "%{$query}%")
            ->paginate(10); // Phân trang kết quả tìm kiếm

        return view('admin.trangthaidonhang', compact('trangthaidonhang')); // Trả về view với danh sách người dùng tìm được
    }
}
