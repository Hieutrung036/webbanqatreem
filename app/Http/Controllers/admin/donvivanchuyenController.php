<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DonViVanChuyen;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Đảm bảo import Rule ở đây


class donvivanchuyenController extends Controller
{
    public function index()
    {
        $donvivanchuyen = DonViVanChuyen::all();
        $donvivanchuyen = DonViVanChuyen::paginate(10); // Lấy 10 người dùng trên mỗi trang
        return view('admin.donvivanchuyen', compact('donvivanchuyen'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:100|unique:donvivanchuyen,ten',
        ], [
            'ten.unique' => 'Trùng tên.', // Tùy chỉnh thông báo lỗi
        ]);


        // Tạo loại sản phẩm mới
        $donvivanchuyen = new DonViVanChuyen();
        $donvivanchuyen->ten = $request->input('ten');

        // Lưu vào cơ sở dữ liệu
        $donvivanchuyen->save();

        // Quay lại trang trước với thông báo thành công
        return redirect()->back()->with('success', 'Thông tin đơn vị vận chuyển đã được thêm thành công!');
    }

    public function destroy($iddvvc)
    {
        $donvivanchuyen = DonViVanChuyen::find($iddvvc);
        $donvivanchuyen->delete();
        return redirect()->back()->with('success', 'Thông tin đơn vị vận chuyển đã được xóa thành công!');
    }
    
    public function update(Request $request, $iddvvc)
    {
        // Xác thực dữ liệu
        $request->validate([
            'ten' => [
                'required',
                'string',
                'max:100',
                Rule::unique('donvivanchuyen')->ignore($iddvvc, 'iddvvc'), // Specify 'idm' as the ID column
            ],
        ], [
            'ten.unique' => 'Trùng tên.', // Tùy chỉnh thông báo lỗi
        ]);
        // Tìm loại sản phẩm
        $donvivanchuyen = DonViVanChuyen::findOrFail($iddvvc);

        // Cập nhật thông tin
        $donvivanchuyen->ten = $request->input('ten');



        // Lưu thay đổi vào cơ sở dữ liệu
        $donvivanchuyen->save();

        return redirect()->back()->with('success', 'Thông tin đơn vị vận chuyển đã được cập nhật thành công.');
    }
    public function search(Request $request)
    {
        $query = $request->input('query'); // Lấy từ khóa tìm kiếm từ yêu cầu

        // Tìm kiếm người dùng theo tên hoặc email
        $donvivanchuyen = DonViVanChuyen::where('ten', 'LIKE', "%{$query}%")
            ->paginate(10); // Phân trang kết quả tìm kiếm

        return view('admin.donvivanchuyen', compact('donvivanchuyen')); // Trả về view với danh sách người dùng tìm được
    }
}