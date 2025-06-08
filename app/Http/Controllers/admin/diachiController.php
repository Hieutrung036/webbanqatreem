<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DiaChi;
use App\Models\KhachHang;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class diachiController extends Controller
{
    public function index()
    {
        $khachhang = KhachHang::all(); // Lấy tất cả người dùng từ cơ sở dữ liệu
        $diachi = DiaChi::all();
        $diachi = DiaChi::paginate(10); // Lấy 10 bản ghi mỗi trang
        return view('admin.diachi', compact('diachi', 'khachhang'));
    }
    
    
    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'tennguoinhan' => 'required|string|max:100',
            'sdt' => ['required', 'regex:/^0[35789]\d{8}$/'],
            'diachi' => 'required|string|max:255',
            'phuongxa' => 'required|string',
            'quanhuyen' => 'required|string',
            'tinhthanhpho' => 'required|string',
            'idkh' => 'required|exists:khachhang,idkh', // Kiểm tra xem idkh có tồn tại không
        ]);

        // Tạo bản ghi mới cho địa chỉ
        $diachi = new DiaChi();
        $diachi->tennguoinhan = $request->input('tennguoinhan');
        $diachi->sdt = $request->input('sdt');
        $diachi->diachi = $request->input('diachi');
        $diachi->phuongxa = $request->input('phuongxa'); // Lưu tên phường/xã
        $diachi->quanhuyen = $request->input('quanhuyen'); // Lưu tên quận/huyện
        $diachi->tinhthanhpho = $request->input('tinhthanhpho'); // Lưu tên tỉnh/thành phố
        $diachi->idkh = $request->input('idkh');

        // Lưu địa chỉ vào database
        $diachi->save();

        // Quay lại trang trước hoặc về trang danh sách người dùng với thông báo thành công
        return redirect()->back()->with('success', 'Địa chỉ đã được thêm thành công!');
    }

    public function destroy($iddc)
    {
        // Tìm người dùng theo id
        $diachi = DiaChi::find($iddc);

        // Kiểm tra xem người dùng có tồn tại không
        if ($diachi) {
            // Xóa người dùng
            $diachi->delete();

            // Trở lại với thông báo thành công
            return redirect()->back()->with('success', 'Địa chỉ đã được xóa thành công!');
        } else {
            // Nếu không tìm thấy người dùng, có thể trả về thông báo lỗi
            return redirect()->back()->with('error', 'Địa chỉ không tồn tại!');
        }
    }

    public function update(Request $request, $iddc)
    {
        // Xác thực dữ liệu
        $request->validate([
            'tennguoinhan' => 'required|string|max:100',
            'sdt' => ['required', 'regex:/^0[35789]\d{8}$/'],
            'diachi' => 'required|string|max:255',
            'phuongxa' => 'required|string',
            'quanhuyen' => 'required|string',
            'tinhthanhpho' => 'required|string',
            'idkh' => 'required|exists:khachhang,idkh',
        ]);

        // Tìm người dùng
        $diachi = DiaChi::findOrFail($iddc);

        $diachi->update($request->all());


        $diachi->save();

        return redirect()->back()->with('success', 'Thông tin người dùng đã được cập nhật thành công.');
    }
    public function search(Request $request)
    {
        $query = $request->input('query'); // Lấy từ khóa tìm kiếm từ yêu cầu
        $khachhang = KhachHang::all(); // Lấy tất cả người dùng từ cơ sở dữ liệu

        // Tìm kiếm người dùng theo tên hoặc email
        $diachi = DiaChi::where('tennguoinhan', 'LIKE', "%{$query}%")
            ->orWhere('diachi', 'LIKE', "%{$query}%")
            ->orWhere('sdt', 'LIKE', "%{$query}%")
            ->orWhere('phuongxa', 'LIKE', "%{$query}%")
            ->orWhere('quanhuyen', 'LIKE', "%{$query}%")
            ->orWhere('tinhthanhpho', 'LIKE', "%{$query}%")

            ->paginate(10); // Phân trang kết quả tìm kiếm

        return view('admin.diachi', compact('diachi', 'khachhang'));
    }
   

}
