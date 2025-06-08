<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KichThuoc;
use Illuminate\Validation\Rule; // Đảm bảo import Rule ở đây

class kichthuocController extends Controller
{
    public function index(){
        $kichthuoc = KichThuoc::all();
        $kichthuoc = KichThuoc::paginate(10); // Lấy 10 người dùng trên mỗi trang
        return view('admin.kichthuoc', compact('kichthuoc'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:100|unique:kichthuoc,ten',
            'mota' => 'nullable|string|max:255',

        ], [
            'ten.unique' => 'Trùng kích thước.', // Tùy chỉnh thông báo lỗi
        ]);


        // Tạo loại sản phẩm mới
        $kichthuoc = new KichThuoc();
        $kichthuoc->ten = $request->input('ten');
        $kichthuoc->mota = $request->input('mota') ?? null; // Lưu null nếu không có giá trị

        // Lưu vào cơ sở dữ liệu
        $kichthuoc->save();

        // Quay lại trang trước với thông báo thành công
        return redirect()->back()->with('success', 'Kích thước đã được thêm thành công!');
    }

    public function destroy($idkt)
    {
        $kichthuoc = KichThuoc::find($idkt);

        if ($idkt) {
            $kichthuoc->delete();
            return redirect()->back()->with('success', 'Kích thước đã được xóa thành công!');
        }

        return redirect()->back();
    }

    public function update(Request $request, $idkt)
    {
        // Xác thực dữ liệu
        $request->validate([
            'ten' => [
                'required',
                'string',
                'max:100',
                Rule::unique('kichthuoc')->ignore($idkt, 'idkt'), // Specify 'idm' as the ID column
            ],
            'mota' => 'required|string|max:255',
        ], [
            'ten.unique' => 'Trùng kích thước.', // Tùy chỉnh thông báo lỗi
        ]);
        // Tìm loại sản phẩm
        $kichthuoc = KichThuoc::findOrFail($idkt);

        // Cập nhật thông tin
        $kichthuoc->ten = $request->input('ten');
        $kichthuoc->mota = $request->input('mota');



        // Lưu thay đổi vào cơ sở dữ liệu
        $kichthuoc->save();

        return redirect()->back()->with('success', 'Thông tin kích thước đã được cập nhật thành công.');
    }
    public function search(Request $request)
    {
        $query = $request->input('query'); // Lấy từ khóa tìm kiếm từ yêu cầu
    
        // Tìm kiếm người dùng theo tên hoặc email
        $kichthuoc = KichThuoc::where('ten', 'LIKE', "%{$query}%")
            ->paginate(10); // Phân trang kết quả tìm kiếm
    
        return view('admin.kichthuoc', compact('kichthuoc')); // Trả về view với danh sách người dùng tìm được
    }
}
