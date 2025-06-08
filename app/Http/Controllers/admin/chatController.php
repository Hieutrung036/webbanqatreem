<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\KhachHang;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    // Phương thức index hiển thị danh sách khách hàng có tin nhắn
    public function index()
    {
        // Lấy danh sách khách hàng có tin nhắn
        $khachHangList = Chat::select('chat.idkh', 'khachhang.ten')
            ->join('khachhang', 'khachhang.idkh', '=', 'chat.idkh')
            ->groupBy('chat.idkh', 'khachhang.ten')
            ->get();

        return view('admin.chat', compact('khachHangList'));
    }

    // Phương thức show hiển thị chi tiết tin nhắn của khách hàng
    // Phương thức show hiển thị chi tiết tin nhắn của khách hàng
    // Phương thức show hiển thị chi tiết tin nhắn của khách hàng
    public function show($idkh)
    {
        // Lấy thông tin khách hàng
        $khachHang = KhachHang::find($idkh);

        // Kiểm tra nếu khách hàng tồn tại

        // Lấy tất cả tin nhắn của khách hàng với idkh
        $chatMessages = Chat::where('idkh', $idkh)->get(); // Đổi tên biến thành chatMessages
        $khachHangList = Chat::select('chat.idkh', 'khachhang.ten', DB::raw('MAX(chat.da_xem = 0 AND chat.loai_nguoi_gui = "khachhang") as co_tin_nhan_moi'))
            ->leftJoin('khachhang', 'khachhang.idkh', '=', 'chat.idkh')
            ->groupBy('chat.idkh', 'khachhang.ten')
            ->get();

        // Truyền dữ liệu vào view
        return view('admin.chat', compact('chatMessages', 'khachHang', 'khachHangList', 'idkh'));
    }



    public function send(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required',
            'idkh' => 'required|exists:khachhang,idkh',
            'idnv' => 'required|exists:nhanvien,idnv',
        ]);

        // Gửi tin nhắn từ nhân viên
        $message = new Chat;
        $message->noidung = $request->content;
        $message->thoigian = now();
        $message->idkh = $request->idkh;
        $message->idnv = $request->idnv;
        $message->loai_nguoi_gui = 'nhanvien'; // Nhân viên gửi
        $message->da_xem = 1; // Tin nhắn của nhân viên luôn được xem
        $message->save();

        // Đánh dấu các tin nhắn chưa đọc của khách hàng là đã xem
        Chat::where('idkh', $request->idkh)
            ->where('loai_nguoi_gui', 'khachhang')
            ->where('da_xem', 0)
            ->update(['da_xem' => 1]);

        return redirect()->route('chat.show', ['idkh' => $request->idkh]);
    }
}
