<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\MaGiamGia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 

class magiamgiaController extends Controller
{
    public function index()
    {
        $magiamgia = MaGiamGia::all();
        $magiamgia = MaGiamGia::paginate(10); 
        return view('admin.magiamgia', compact('magiamgia'));
    }
    public function store(Request $request)
{
    $request->validate([
        'code' => 'required|string|max:100|unique:giamgia,code', // Thay 'code' bằng 'ten' trong quy tắc xác thực
        'phantram' => 'required|numeric|min:0|max:100', // Chỉnh sửa để yêu cầu số
        'mota' => 'required|string|max:255',
        'soluong' => 'required|integer|min:1', // Chỉnh sửa để yêu cầu số nguyên
        'ngaybatdau' => 'required|date', // Thêm xác thực cho trường ngày bắt đầu
        'ngayketthuc' => 'required|date|after_or_equal:ngaybatdau', // Thêm xác thực cho trường ngày kết thúc
    ], [
        'code.unique' => 'Mã giảm giá đã tồn tại.', // Tùy chỉnh thông báo lỗi
        'phantram.numeric' => 'Phần trăm phải là số.', // Thông báo lỗi cho phần trăm
        'soluong.integer' => 'Số lượng phải là số nguyên.', // Thông báo lỗi cho số lượng
        'ngayketthuc.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.', // Thông báo lỗi cho ngày kết thúc
    ]);

    // Tạo mã giảm giá mới
    $magiamgia = new MaGiamGia();
    $magiamgia->code = $request->input('code');
    $magiamgia->phantram = $request->input('phantram'); // Lưu phần trăm
    $magiamgia->mota = $request->input('mota');
    $magiamgia->soluong = $request->input('soluong'); // Lưu số lượng
    $magiamgia->ngaybatdau = $request->input('ngaybatdau'); // Lưu ngày bắt đầu
    $magiamgia->ngayketthuc = $request->input('ngayketthuc'); // Lưu ngày kết thúc

    // Lưu vào cơ sở dữ liệu
    $magiamgia->save();

    // Quay lại trang trước với thông báo thành công
    return redirect()->back()->with('success', 'Mã giảm giá đã được thêm thành công!');
}


    public function destroy($idgg)
    {
        $magiamgia = MaGiamGia::find($idgg);

        $magiamgia->delete();

    // Quay lại với thông báo thành công
        return redirect()->back()->with('success', 'Xóa mã giảm giá thành công!');

    }

    public function update(Request $request, $idgg)
    {
        // Xác thực dữ liệu
        $request->validate([
            'code' => [
                'required',
                'string',
                'max:100',
                Rule::unique('giamgia')->ignore($idgg, 'idgg'), // Specify 'idm' as the ID column
            ],
            'phantram' => 'required|numeric|min:0|max:100', // Chỉnh sửa để yêu cầu số
            'mota' => 'required|string|max:255',
            'soluong' => 'required|integer|min:0', // Chỉnh sửa để yêu cầu số nguyên
            'ngaybatdau' => 'required|date', // Thêm xác thực cho trường ngày bắt đầu
            'ngayketthuc' => 'required|date|after_or_equal:ngaybatdau', // Thêm xác thực cho trường ngày kết thúc
        ], [
            'code.unique' => 'Mã giảm giá đã tồn tại.', // Tùy chỉnh thông báo lỗi
            'phantram.numeric' => 'Phần trăm phải là số.', // Thông báo lỗi cho phần trăm
            'soluong.integer' => 'Số lượng phải là số nguyên.', // Thông báo lỗi cho số lượng
            'ngayketthuc.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.', // Thông báo lỗi cho ngày kết thúc
        ]);
        // Tìm loại sản phẩm
        $magiamgia = MaGiamGia::findOrFail($idgg);

        // Cập nhật thông tin
        $magiamgia->code = $request->input('code');
        $magiamgia->phantram = $request->input('phantram'); // Lưu phần trăm
        $magiamgia->mota = $request->input('mota');
        $magiamgia->soluong = $request->input('soluong'); // Lưu số lượng
        $magiamgia->ngaybatdau = $request->input('ngaybatdau'); // Lưu ngày bắt đầu
        $magiamgia->ngayketthuc = $request->input('ngayketthuc'); // Lưu ngày kết thúc

        // Lưu thay đổi vào cơ sở dữ liệu
        $magiamgia->save();

        return redirect()->back()->with('success', 'Thông tin giảm giá đã được cập nhật thành công.');
    }
    public function search(Request $request)
    {
        $query = $request->input('query'); // Lấy từ khóa tìm kiếm từ yêu cầu
    
        // Tìm kiếm người dùng theo tên hoặc email
        $magiamgia = MaGiamGia::where('code', 'LIKE', "%{$query}%")
        ->orWhere('phantram', 'LIKE', "%{$query}%")
        ->orWhere('soluong', 'LIKE', "%{$query}%")
        ->orWhere('ngaybatdau', 'LIKE', "%{$query}%")
        ->orWhere('ngayketthuc', 'LIKE', "%{$query}%")
            ->paginate(10); // Phân trang kết quả tìm kiếm
    
        return view('admin.magiamgia', compact('magiamgia')); // Trả về view với danh sách người dùng tìm được
    }
}
