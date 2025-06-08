<?php


namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChiTietGioHang;
use App\Models\DanhMucSanPham;
use Illuminate\Http\Request;
use App\Models\LoaiSanPham;
use App\Models\LoaiTinTuc;

class chatController extends Controller
{
    public function index()
    {
        $danhmucsanpham = DanhMucSanPham::all();
        $loaitintuc = LoaiTinTuc::all();
        if (auth()->check()) {
            $idkh = auth()->user()->idkh;

            // Lấy chi tiết giỏ hàng của người dùng
            $chitietgiohang = ChiTietGioHang::with('chitietsanpham.sanpham')
                ->whereHas('giohang', function ($query) use ($idkh) {
                    $query->where('idkh', $idkh);
                })
                ->get();

            // Tính tổng tiền
            $tongTien = 0;
            $soLuongSanPham = 0;
            $tinNhan = Chat::where('idkh', $idkh)
                ->orderBy('thoigian', 'asc')
                ->get();
            foreach ($chitietgiohang as $ctgh) {
                foreach ($ctgh->chitietsanpham as $ctsp) {
                    $giaSanPham = $ctsp->sanpham->gia;

                    // Kiểm tra giảm giá
                    if ($ctsp->sanpham->giamgia && $ctsp->sanpham->giamgia->phantram > 0) {
                        $giaSanPham -= ($giaSanPham * $ctsp->sanpham->giamgia->phantram) / 100;
                    }

                    // Tính tổng tiền cho sản phẩm (số lượng * giá mỗi sản phẩm)
                    $tongTien += $giaSanPham * $ctgh->soluong;
                    $soLuongSanPham += $ctgh->soluong;
                }
            }
            return view('client.chat', compact('danhmucsanpham', 'loaitintuc', 'chitietgiohang', 'tongTien', 'soLuongSanPham', 'tinNhan'));
        } else {
            // Lấy chi tiết giỏ hàng từ session
            $chitietgiohang = session('giohang', []);

            $tongTien = 0; // Khởi tạo tổng tiền
            $soLuongSanPham = 0; // Khởi tạo số lượng sản phẩm

            foreach ($chitietgiohang as $item) {
                if (isset($item['sanpham']) && $item['sanpham'] instanceof \App\Models\ChiTietSanPham) {
                    $sanpham = $item['sanpham']; // Lấy đối tượng ChiTietSanPham

                    // Lấy giá sản phẩm
                    $giaSanPham = $sanpham->sanpham->gia ?? 0;

                    // Kiểm tra và áp dụng giảm giá nếu có
                    if (isset($sanpham->sanpham->giamgia) && $sanpham->sanpham->giamgia->phantram > 0) {
                        $giaSanPham -= ($giaSanPham * $sanpham->sanpham->giamgia->phantram) / 100;
                    }

                    // Tính tổng tiền và số lượng sản phẩm
                    $tongTien += $giaSanPham * $item['soluong'];
                    $soLuongSanPham += $item['soluong'];
                }
            }

            // Trả về view `giohang1` với các giá trị đã tính toán
            return view('client.chat', compact('danhmucsanpham', 'loaitintuc', 'chitietgiohang', 'tongTien', 'soLuongSanPham'));
        }
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $idkh = auth()->user()->idkh;

        $message = new Chat();
        $message->noidung = $request->content;
        $message->thoigian = now();
        $message->idkh = $idkh;
        $message->idnv = null; // Tin nhắn từ khách hàng
        $message->loai_nguoi_gui = 'khachhang'; // Phân biệt người gửi
        $message->save();

        return redirect()->route('client.chat');
    }

    
}
