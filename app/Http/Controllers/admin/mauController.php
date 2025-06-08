<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mau;
use Illuminate\Validation\Rule; // Đảm bảo import Rule ở đây

class mauController extends Controller
{
    public function index()
    {
        $mau = Mau::all();
        $mau = Mau::paginate(10); // Lấy 10 người dùng trên mỗi trang
        return view('admin.mau', compact('mau'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:100|unique:mau,ten',
        ], [
            'ten.unique' => 'Trùng màu.', // Tùy chỉnh thông báo lỗi
        ]);


        // Tạo loại sản phẩm mới
        $mau = new Mau();
        $mau->ten = $request->input('ten');

        // Lưu vào cơ sở dữ liệu
        $mau->save();

        // Quay lại trang trước với thông báo thành công
        return redirect()->back()->with('success', 'Màu đã được thêm thành công!');
    }

    public function destroy($idm)
    {
        $mau = Mau::find($idm);
        $mau->delete();
        return redirect()->back()->with('success', 'Màu đã được xóa thành công!');
    }
    
    public function update(Request $request, $idm)
    {
        // Xác thực dữ liệu
        $request->validate([
            'ten' => [
                'required',
                'string',
                'max:100',
                Rule::unique('mau')->ignore($idm, 'idm'), // Specify 'idm' as the ID column
            ],
        ], [
            'ten.unique' => 'Trùng màu.', // Tùy chỉnh thông báo lỗi
        ]);
        // Tìm loại sản phẩm
        $mau = Mau::findOrFail($idm);

        // Cập nhật thông tin
        $mau->ten = $request->input('ten');



        // Lưu thay đổi vào cơ sở dữ liệu
        $mau->save();

        return redirect()->back()->with('success', 'Thông tin màu đã được cập nhật thành công.');
    }
    public function search(Request $request)
    {
        $query = $request->input('query'); // Lấy từ khóa tìm kiếm từ yêu cầu

        // Tìm kiếm người dùng theo tên hoặc email
        $mau = Mau::where('ten', 'LIKE', "%{$query}%")
            ->paginate(10); // Phân trang kết quả tìm kiếm

        return view('admin.mau', compact('mau')); // Trả về view với danh sách người dùng tìm được
    }
}
