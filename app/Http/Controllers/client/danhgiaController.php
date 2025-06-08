<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\ChiTietDonHang;
use App\Models\ChiTietGioHang;
use App\Models\ChiTietHoaDon;
use Illuminate\Http\Request;
use App\Models\DanhGia;
use App\Models\DanhMucSanPham;
use App\Models\HoaDon;
use App\Models\LoaiTinTuc;
use Carbon\Carbon;

class danhgiaController extends Controller
{




    public function index($idhd)
    {

        if (!auth()->check()) {
            return redirect()->route('trangchu'); // Chuyển hướng về trang chủ
        }
        
        $danhmucsanpham = DanhMucSanPham::all();
        $loaitintuc = LoaiTinTuc::all();
        if (auth()->check()) {
            $idkh = auth()->user()->idkh;
            $hoadon = HoaDon::with('chitiethoadon.chitietsanpham.sanpham', 'chitiethoadon.chitietsanpham.mau', 'chitiethoadon.chitietsanpham.kichthuoc')
                ->where('idhd', $idhd)
                ->first();

            if ($hoadon) {
                $chitiethoadon = $hoadon->chitiethoadon;  // Lấy chi tiết đơn hàng từ HoaDon
            }


            $chitietgiohang = ChiTietGioHang::with('chitietsanpham.sanpham')
                ->whereHas('giohang', function ($query) use ($idkh) {
                    $query->where('idkh', $idkh);
                })
                ->get();

            // Tính tổng tiền và số lượng sản phẩm trong giỏ hàng
            $tongTien = 0;
            $soLuongSanPham = 0;

            foreach ($chitietgiohang as $ctgh) {
                foreach ($ctgh->chitietsanpham as $ctsp) {
                    $giaSanPham = $ctsp->sanpham->gia;

                    // Kiểm tra giảm giá
                    if ($ctsp->sanpham->giamgia && $ctsp->sanpham->giamgia->phantram > 0) {
                        $giaSanPham -= ($giaSanPham * $ctsp->sanpham->giamgia->phantram) / 100;
                    }

                    // Cộng dồn tổng tiền và số lượng
                    $tongTien += $giaSanPham * $ctgh->soluong;
                    $soLuongSanPham += $ctgh->soluong;
                }
            }
            return view('client.danhgia', compact(
                'danhmucsanpham',
                'loaitintuc',
                'chitiethoadon',
                'chitietgiohang',
                'tongTien',
                'soLuongSanPham',

            ));
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
            return view('client.danhgia', compact('danhmucsanpham', 'loaitintuc', 'chitietgiohang', 'tongTien', 'soLuongSanPham'));
        }
    }


    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'idctsp' => 'required|exists:chitietsanpham,idctsp',
            'sosao' => 'required|integer|between:1,5',
            'Noidung' => 'required|string|max:500',
        ]);

        // Lưu đánh giá vào cơ sở dữ liệu
        $danhgia = new DanhGia();
        $danhgia->idctsp = $request->idctsp;
        $danhgia->thoigian = Carbon::now('Asia/Ho_Chi_Minh');

        $danhgia->idkh = auth()->user()->idkh; // Lấy id khách hàng đã đăng nhập
        $danhgia->sosao = $request->sosao;
        $danhgia->noidung = $request->Noidung;
        $danhgia->save();


        return redirect()->route('trangchu')->with('success', 'Cảm ơn bạn đã đánh giá!!.');

        // Phản hồi lại người dùng
    }
}
