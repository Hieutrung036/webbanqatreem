<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PhuongThucThanhToan;
use Illuminate\Validation\Rule; // Đảm bảo import Rule ở đây

class phuongthucthanhtoanController extends Controller
{
    public function index()
    {
        $phuongthucthanhtoan = PhuongThucThanhToan::all();
        $phuongthucthanhtoan = PhuongThucThanhToan::paginate(10); 
        return view('admin.phuongthucthanhtoan', compact('phuongthucthanhtoan'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:100|unique:phuongthucthanhtoan,ten',
            'mota' => 'required|string|max:255',
        ], [
            'ten.unique' => 'Trùng phương thức.', // Tùy chỉnh thông báo lỗi
        ]);


        // Tạo loại sản phẩm mới
        $phuongthucthanhtoan = new PhuongThucThanhToan();
        $phuongthucthanhtoan->ten = $request->input('ten');
        $phuongthucthanhtoan->mota = $request->input('mota');

        // Lưu vào cơ sở dữ liệu
        $phuongthucthanhtoan->save();

        // Quay lại trang trước với thông báo thành công
        return redirect()->back()->with('success', 'Phương thức thanh toán đã được thêm thành công!');
    }

    public function destroy($idpttt)
    {
        $phuongthucthanhtoan = PhuongThucThanhToan::find($idpttt);

        if ($phuongthucthanhtoan) {
            $phuongthucthanhtoan->delete();
            return redirect()->back()->with('success', 'Phương thức thanh toán đã được xóa thành công!');
        }

        return redirect()->back();
    }

    public function update(Request $request, $idpttt)
    {
        // Xác thực dữ liệu
        $request->validate([
            'ten' => [
                'required',
                'string',
                'max:100',
                Rule::unique('phuongthucthanhtoan')->ignore($idpttt, 'idpttt'), // Specify 'idm' as the ID column
            ],
            'mota' => 'required|string|max:255',
        ], [
            'ten.unique' => 'Trùng phương thức.', // Tùy chỉnh thông báo lỗi
        ]);
        // Tìm loại sản phẩm
        $phuongthucthanhtoan = PhuongThucThanhToan::findOrFail($idpttt);

        // Cập nhật thông tin
        $phuongthucthanhtoan->ten = $request->input('ten');
        $phuongthucthanhtoan->mota = $request->input('mota');



        // Lưu thay đổi vào cơ sở dữ liệu
        $phuongthucthanhtoan->save();

        return redirect()->back()->with('success', 'Thông tin phương thức thanh toán đã được cập nhật thành công.');
    }
    public function search(Request $request)
    {
        $query = $request->input('query'); // Lấy từ khóa tìm kiếm từ yêu cầu
    
        // Tìm kiếm người dùng theo tên hoặc email
        $phuongthucthanhtoan = PhuongThucThanhToan::where('ten', 'LIKE', "%{$query}%")
            ->paginate(10); // Phân trang kết quả tìm kiếm
    
        return view('admin.phuongthucthanhtoan', compact('phuongthucthanhtoan')); // Trả về view với danh sách người dùng tìm được
    }
}
