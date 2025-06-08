<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ThuongHieu;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Đảm bảo import Rule ở đây

class thuonghieuController extends Controller
{
    public function index()
    {
        $thuonghieu = ThuongHieu::all();
        $thuonghieu = ThuongHieu::withCount('sanpham')->paginate(10);

        return view('admin.thuonghieu', compact('thuonghieu'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:100|unique:thuonghieu,ten',
        ], [
            'ten.unique' => 'Trùng thương hiệu.', // Tùy chỉnh thông báo lỗi
        ]);


        // Tạo loại sản phẩm mới
        $thuonghieu = new ThuongHieu();
        $thuonghieu->ten = $request->input('ten');

        // Lưu vào cơ sở dữ liệu
        $thuonghieu->save();

        // Quay lại trang trước với thông báo thành công
        return redirect()->back()->with('success', 'Thương hiệu đã được thêm thành công!');
    }

    public function destroy($idth)
    {
        $thuonghieu = thuonghieu::find($idth);

        if ($thuonghieu) {
            $thuonghieu->delete();
            return redirect()->back()->with('success', 'Thương hiệu đã được xóa thành công!');
        }

        return redirect()->back();
    }

    public function update(Request $request, $idth)
    {

        $request->validate([
            'ten' => [
                'required',
                'string',
                'max:100',
                Rule::unique('thuonghieu')->ignore($idth, 'idth'), // Specify 'idm' as the ID column
            ],
        ], [
            'ten.unique' => 'Trùng thương hiệu.', // Tùy chỉnh thông báo lỗi
        ]);
        $thuonghieu = ThuongHieu::findOrFail($idth);
        $thuonghieu->ten = $request->input('ten');
        $thuonghieu->save();

        return redirect()->back()->with('success', 'Thông tin thương hiệu đã được cập nhật thành công.');
    }
    public function search(Request $request)
    {
        $query = $request->input('query'); // Lấy từ khóa tìm kiếm từ yêu cầu

        $thuonghieu = ThuongHieu::where('ten', 'LIKE', "%{$query}%")
            ->paginate(10); // Phân trang kết quả tìm kiếm

        return view('admin.thuonghieu', compact('thuonghieu')); // Trả về view với danh sách người dùng tìm được
    }
}
