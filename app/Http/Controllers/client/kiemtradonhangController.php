<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\ChiTietGioHang;
use App\Models\DanhMucSanPham;
use App\Models\DiaChi;
use App\Models\HoaDon;
use App\Models\LoaiTinTuc;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class kiemtradonhangController extends Controller
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
            return view('client.thongtin', compact('danhmucsanpham', 'loaitintuc', 'chitietgiohang', 'tongTien', 'soLuongSanPham'));
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
            return view('client.kiemtradonhang', compact('danhmucsanpham', 'loaitintuc', 'chitietgiohang', 'tongTien', 'soLuongSanPham'));
        }
    }




    // public function kiemTraDonHang(Request $request)
    // {
    //     $validated = $request->validate([
    //         'sdt' => 'required|digits_between:10,11',
    //     ]);


    //     $orders = DB::table('hoadon')
    //         ->join('diachi', 'hoadon.iddc', '=', 'diachi.iddc') // Sửa lại join cho đúng
    //         ->join('trangthaidonhang', 'hoadon.idttdh', '=', 'trangthaidonhang.idttdh')  // Thêm JOIN với bảng trangthaidonhang

    //         ->select(
    //             'hoadon.idhd as ma_don_hang',
    //             'hoadon.tongtien',
    //             'hoadon.ngaydathang',
    //             'hoadon.ngaynhanhang',
    //             'trangthaidonhang.ten as trang_thai',  // Lấy tên trạng thái
    //             'diachi.sdt'
    //         )
    //         ->where('diachi.sdt', $validated['sdt'])
    //         ->get()
    //         ->map(function ($order) {
    //             $order->ngaydathang = Carbon::parse($order->ngaydathang)->format('d-m-Y');
    //             $order->ngaynhanhang = Carbon::parse($order->ngaynhanhang)->format('d-m-Y');
    //             return $order;
    //         });
    //     if ($orders->isEmpty()) {
    //         return response()->json(['status' => 'error', 'message' => 'Không tìm thấy đơn hàng!'], 404);
    //     }

    //     return response()->json([
    //         'status' => 'success',
    //         'data' => $orders,
    //     ]);
    // }
    public function kiemTraDonHang(Request $request)
    {
        $validated = $request->validate([
            'idhd' => 'nullable|regex:/^DH00000\d+$/', // Chỉ chấp nhận định dạng DH00000 + số
            'sdt' => 'required|digits_between:10,11',
        ]);

        $idhd = $validated['idhd'] ?? null;

        if ($idhd) {
            // Loại bỏ tiền tố DH00000 để so khớp với cơ sở dữ liệu
            $idhd = str_replace('DH00000', '', $idhd);
        }

        // Truy vấn dữ liệu từ bảng `chitiethoadon`
        $query = DB::table('chitiethoadon')
            ->join('hoadon', 'chitiethoadon.idhd', '=', 'hoadon.idhd')
            ->join('diachi', 'hoadon.iddc', '=', 'diachi.iddc')
            ->join('khachhang', 'hoadon.idkh', '=', 'khachhang.idkh')
            ->join('trangthaidonhang', 'hoadon.idttdh', '=', 'trangthaidonhang.idttdh')
            ->join('chitietsanpham', 'chitiethoadon.idctsp', '=', 'chitietsanpham.idctsp')
            ->join('mau', 'chitietsanpham.idm', '=', 'mau.idm')  // Thêm phép join với bảng `mau`
            ->join('kichthuoc', 'chitietsanpham.idkt', '=', 'kichthuoc.idkt')  // Thêm phép join với bảng `mau`
            ->join('sanpham', 'chitietsanpham.idsp', '=', 'sanpham.idsp')  // Thêm phép join với bảng `mau`

            ->select(
                'hoadon.idhd as ma_don_hang',
                'hoadon.tongtien',
                'hoadon.ngaydathang',
                'hoadon.ngaynhanhang',
                'trangthaidonhang.ten as trang_thai',
                'khachhang.ten',
                'diachi.diachi',
                'diachi.phuongxa',
                'diachi.quanhuyen',
                'diachi.tinhthanhpho',
                'mau.ten as mau_san_pham',  // Đặt tên cột rõ ràng cho màu sản phẩm
                'kichthuoc.ten as kich_thuoc',  // Đặt tên cột rõ ràng cho màu sản phẩm
            'kichthuoc.mota as kich_thuoc_mota',  // Đặt tên cột rõ ràng cho màu sản phẩm
            'sanpham.ten as ten_sp',  // Đặt tên cột rõ ràng cho màu sản phẩm

                'chitiethoadon.soluong'
            )
            ->where('diachi.sdt', $validated['sdt']);

        // Nếu có mã đơn hàng, thêm điều kiện tìm kiếm theo mã đơn hàng
        if ($idhd) {
            $query->where('hoadon.idhd', $idhd);
        }

        // Lấy dữ liệu và xử lý định dạng ngày tháng
        $orders = $query->get()->map(function ($order) {
            $order->ngaydathang = Carbon::parse($order->ngaydathang)->format('d-m-Y');
            $order->ngaynhanhang = Carbon::parse($order->ngaynhanhang)->format('d-m-Y');
            return $order;
        });

        // Kiểm tra nếu không tìm thấy đơn hàng
        if ($orders->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'Không tìm thấy đơn hàng!'], 404);
        }

        // Trả về kết quả tìm thấy đơn hàng
        return response()->json([
            'status' => 'success',
            'data' => $orders,
        ]);
    }






    // Ví dụ cập nhật trong controller
    // public function chiTietDonHang($orderId)
    // {

    //     Truy vấn chi tiết đơn hàng
    //     $orderDetails = DB::table('chitiethoadon')
    //     ->join('chitietsanpham', 'chitiethoadon.idctsp', '=', 'chitietsanpham.idctsp')
    //     ->join('hoadon', 'chitiethoadon.idhd',
    //         '=',
    //         'hoadon.idhd'
    //     )
    //     ->join('mau', 'chitietsanpham.idmau', '=', 'mau.idm')
    //     ->join('kichthuoc', 'chitietsanpham.idkichthuoc', '=', 'kichthuoc.idkt')
    //     ->select('chitietsanpham.ten', 'chitietsanpham.gia', 'chitiethoadon.soluong', 'mau.ten as mau', 'kichthuoc.ten as kichthuoc')
    //     ->where('chitiethoadon.idhd', $orderId)
    //     ->get();

    //     if ($orderDetails->isEmpty()) {
    //         return response()->json(['status' => 'error', 'message' => 'Không tìm thấy chi tiết đơn hàng!'], 404);
    //     }

    //     Trả về view và truyền orderId
    //     return view('client.kiemtradonhang', [
    //         'orderDetails' => $orderDetails,
    //         'orderId' => $orderId
    //     ]);
    // }
    // Route

    // Controller




}
