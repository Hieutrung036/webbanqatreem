<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DanhGia;
use App\Models\KhachHang;
use App\Models\PhanHoi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class danhgiaController extends Controller
{
    public function index()
    {
        $khachhang = KhachHang::all(); // Lấy tất cả người dùng từ cơ sở dữ liệu
        $danhgia = DanhGia::all();
        $danhgia = DanhGia::with('phanhoi')->paginate(10);
        return view('admin.danhgia', compact('danhgia', 'khachhang'));
    }

    public function store(Request $request)
    {
        // Kiểm tra xem nhân viên đã đăng nhập chưa
        if (auth('nhanvien')->check()) {
            // Tạo mới đối tượng PhanHoi
            $phanhoi = new PhanHoi();

            // Gán các giá trị cần thiết cho PhanHoi
            $phanhoi->idnv = auth('nhanvien')->user()->idnv;
            $phanhoi->noidung = $request->noidung;
            $phanhoi->thoigian = Carbon::now('Asia/Ho_Chi_Minh');
            $phanhoi->iddg = $request->iddg;
            $phanhoi->save();



            return redirect()->back()->with('success', 'Phản hồi thành công.');
        } else {
            return redirect()->route('admin.dangnhap')->with('error', 'Vui lòng đăng nhập trước.');
        }
    }






    public function destroy($iddg)
    {
        $danhgia = DanhGia::find($iddg);

        if ($danhgia) {
            // Xóa tất cả phản hồi liên quan
            $danhgia->phanhoi()->delete();

            // Sau đó xóa đánh giá
            $danhgia->delete();

            return redirect()->back()->with('success', 'Đánh giá và phản hồi liên quan đã được xóa thành công!');
        }

        return redirect()->back()->with('error', 'Không tìm thấy đánh giá cần xóa!');
    }

    public function search(Request $request)
    {
        $khachhang = KhachHang::all(); // Lấy tất cả người dùng từ cơ sở dữ liệu
        $danhgia = DanhGia::all();
        $query = $request->input('query'); // Lấy từ khóa tìm kiếm từ yêu cầu

        // Tìm kiếm người dùng theo tên hoặc email
        $danhgia = DanhGia::where('sosao', 'like', '%' . $query . '%')
            ->orWhere('noidung', 'like', '%' . $query . '%')
            ->paginate(10);

        $khachhang = KhachHang::where('ten', 'like', '%' . $query . '%')->paginate(10);

        return view('admin.danhgia', compact('danhgia', 'khachhang')); // Trả về view với danh sách người dùng tìm được
    }
}
