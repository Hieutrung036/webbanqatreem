<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Mail\ThongBaoDonHangMail;
use App\Models\ChiTietGioHang;
use App\Models\ChiTietHoaDon;
use App\Models\ChiTietSanPham;
use App\Models\DanhMucSanPham;
use App\Models\DiaChi;
use App\Models\GioHang;
use App\Models\HoaDon;
use App\Models\KichThuoc;
use App\Models\LoaiSanPham;
use App\Models\LoaiTinTuc;
use App\Models\MaGiamGia;
use App\Models\Mau;
use App\Models\PhuongThucGiaoHang;
use App\Models\PhuongThucThanhToan;
use App\Models\Sanpham;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class thanhtoansanphamController extends Controller
{
    public function index(Request $request)
    {
        // Lấy thông tin các loại sản phẩm và tin tức
        $loaisanpham = LoaiSanPham::all();
        $loaitintuc = LoaiTinTuc::all();
        $danhmucsanpham = DanhMucSanPham::all();

        // Lấy thông tin giỏ hàng
        $chitietgiohang = ChiTietGioHang::with('chitietsanpham.sanpham')->get();
        $phuongthucgiaohang = PhuongThucGiaoHang::all();

        if (auth()->check()) {
            $idkh = auth()->user()->idkh;
            $user = auth()->user();
            $diachi = DiaChi::where('idkh', $idkh)->get();
            $phuongthucthanhtoan = PhuongThucThanhToan::all();

            // Lọc giỏ hàng theo người dùng đã đăng nhập
            $chitietgiohang = ChiTietGioHang::with('chitietsanpham.sanpham')
                ->whereHas('giohang', function ($query) use ($idkh) {
                    $query->where('idkh', $idkh);
                })
                ->get();

            // Tính tổng tiền trước khi giảm giá
            $tongTien = 0; // Tổng tiền cơ bản
            $tongTienGG = 0; // Tổng tiền sau giảm giá
            $tongTienShip = 0; // Tổng tiền cuối cùng
            $soLuongSanPham = 0;
            // Lặp qua các chi tiết giỏ hàng và tính tổng tiền
            foreach ($chitietgiohang as $ctgh) {
                foreach ($ctgh->chitietsanpham as $ctsp) {
                    $giaSanPham = $ctsp->sanpham->gia;

                    // Kiểm tra giảm giá của sản phẩm
                    if ($ctsp->sanpham->giamgia && $ctsp->sanpham->giamgia->phantram > 0) {
                        $giaSanPham -= ($giaSanPham * $ctsp->sanpham->giamgia->phantram) / 100;
                    }

                    // Cộng dồn tổng tiền và số lượng sản phẩm
                    $tongTien += $giaSanPham * $ctgh->soluong;
                    $soLuongSanPham += $ctgh->soluong;
                }
            }

            $voucherCode = $request->input('voucherCode');
            $voucherDiscount = 0;

            if ($voucherCode) {
                $magiamgia = MaGiamGia::where('code', $voucherCode)->first();
                if ($magiamgia) {
                    $voucherDiscount = $magiamgia->phantram;
                }
            }
            $tongTienGG = $tongTien - ($tongTien * $voucherDiscount / 100);

            // Lấy phương thức vận chuyển
            $idPhuongThuc = $request->input('phuongthucvanchuyen');
            $phuongthucgiaohangSelected = PhuongThucGiaoHang::find($idPhuongThuc);

            // Tính tổng tiền sau khi áp dụng phí vận chuyển
            if ($phuongthucgiaohangSelected) {
                $tongTienShip = $tongTienGG + $phuongthucgiaohangSelected->phigiaohang;
            } else {
                $tongTienShip = $tongTienGG;
            }



            // Nếu yêu cầu AJAX, trả về JSON với các giá trị tính toán
            if ($request->ajax()) {
                return response()->json([
                    'tongTienShip' => number_format($tongTienShip, 0, ',', '.'),
                ]);
            }
        } else {
            // Nếu người dùng chưa đăng nhập, giỏ hàng trống và tổng tiền bằng 0
            $chitietgiohang = [];
            $tongTien = 0;
            $soLuongSanPham = 0;
            $tongTienShip = 0; // Mặc định không có tiền ship khi chưa đăng nhập
        }

        return view('client.thanhtoansanpham', compact(
            'loaisanpham',
            'loaitintuc',
            'chitietgiohang',
            'tongTien',
            'tongTienShip',
            'soLuongSanPham',
            'phuongthucgiaohang',
            'phuongthucthanhtoan',
            'user',
            'diachi',
            'danhmucsanpham',
            'voucherDiscount' // Truyền discount voucher vào view để hiển thị
        ));
    }

    public function xulythanhtoan(Request $request)
    {
        // $iidc = request('idpttt');
        // dd($iidc);

        if (auth()->check()) {
            // Lấy thông tin người dùng
            $idkh = auth()->user()->idkh;
            $user = auth()->user();

            // dd($user);
            // Lấy thông tin giỏ hàng
            $chitietgiohang = ChiTietGioHang::with('chitietsanpham.sanpham')
                ->whereHas('giohang', function ($query) use ($idkh) {
                    $query->where('idkh', $idkh);
                })
                ->get();
            // dd( $chitietgiohang);
            // Kiểm tra giỏ hàng có trống không
            if ($chitietgiohang->isEmpty()) {
                return redirect()->route('giohang')->with('error', 'Giỏ hàng của bạn hiện tại trống.');
            }

            // Tính tổng tiền trước khi giảm giá
            $tongTien = 0; // Tổng tiền cơ bản
            $tongTienGG = 0; // Tổng tiền sau giảm giá
            $tongTienShip = 0; // Tổng tiền cuối cùng
            $soLuongSanPham = 0;
            // Lặp qua các chi tiết giỏ hàng và tính tổng tiền
            foreach ($chitietgiohang as $ctgh) {
                foreach ($ctgh->chitietsanpham as $ctsp) {
                    $giaSanPham = $ctsp->sanpham->gia;

                    // Kiểm tra giảm giá của sản phẩm
                    if ($ctsp->sanpham->giamgia && $ctsp->sanpham->giamgia->phantram > 0) {
                        $giaSanPham -= ($giaSanPham * $ctsp->sanpham->giamgia->phantram) / 100;
                    }

                    // Cộng dồn tổng tiền và số lượng sản phẩm
                    $tongTien += $giaSanPham * $ctgh->soluong;
                    $soLuongSanPham += $ctgh->soluong;
                }
            }

            $voucherCode = $request->input('voucherCode');
            $voucherDiscount = 0;
            $idgg = null;  // Mã giảm giá (nếu có)

            if ($voucherCode) {
                $magiamgia = MaGiamGia::where('code', $voucherCode)->first();
                if ($magiamgia) {
                    $voucherDiscount = $magiamgia->phantram;
                    $idgg = $magiamgia->idgg;  // Lấy ID mã giảm giá
                }
            }
            $tongTienGG = $tongTien - ($tongTien * $voucherDiscount / 100);

            // Lấy phương thức vận chuyển
            $idPhuongThuc = $request->input('phuongthucvanchuyen');
            $phuongthucgiaohangSelected = PhuongThucGiaoHang::find($idPhuongThuc);

            // Tính tổng tiền sau khi áp dụng phí vận chuyển
            if ($phuongthucgiaohangSelected) {
                $tongTienShip = $tongTienGG + $phuongthucgiaohangSelected->phigiaohang;
            } else {
                $tongTienShip = $tongTienGG;
            }

            // Lấy phương thức giao hàng và thanh toán
            $phuongthucthanhtoan = $request->input('idpttt'); // Lấy giá trị ID phương thức thanh toán từ form

            // Tìm phương thức thanh toán theo ID
            $phuongthuc = PhuongThucThanhToan::find($phuongthucthanhtoan);

            $idpttt = $phuongthuc->idpttt;

            $phuongthucvanchuyen = PhuongThucGiaoHang::find($request->input('phuongthucvanchuyen'));

            if (!$phuongthucvanchuyen) {
                return redirect()->back()->with('error', 'Vui lòng chọn phương thức vận chuyển.');
            }

            $idptgh = $phuongthucvanchuyen->idptgh;



            // Tính ngày giao hàng dựa vào phương thức vận chuyển
            $ngayNhanHang = Carbon::now('Asia/Ho_Chi_Minh')->addDays($phuongthucvanchuyen->ngaydukien);

            // Lấy địa chỉ giao hàng của người dùng
            // $diachi = DiaChi::where('idkh', $idkh)->first();

            // // Kiểm tra nếu không có địa chỉ giao hàng thì thông báo lỗi hoặc xử lý khác
            // if (!$diachi) {
            //     return redirect()->back()->with('error', 'Bạn chưa có địa chỉ giao hàng.');
            // }

            // $iddc = $diachi->iddc;
            $iddc = $request->input('iddc');

            // Kiểm tra nếu không có iddc, có thể hiển thị lỗi hoặc xử lý theo yêu cầu
            if (!$iddc) {
                return redirect()->back()->with('error', 'Vui lòng chọn địa chỉ!');
            }

            // Tạo đơn hàng
            $hoadon = HoaDon::create([
                'idkh' => $idkh,
                'idgg' => $idgg, // Mã giảm giá (nếu có)
                'tongtien' => $tongTienShip, // Tổng tiền + phí vận chuyển
                'ngaylap' => null, // Ngày đặt hàng
                'ngaydathang' => Carbon::now('Asia/Ho_Chi_Minh'), // Ngày đặt hàng
                'ngaynhanhang' => $ngayNhanHang, // Ngày giao hàng dự kiến
                'idpttt' => $idpttt, // Lưu ID phương thức thanh toán
                'idptgh' => $idptgh, // Phương thức giao hàng
                'idttdh' => 1, // Trạng thái đơn hàng (1 là Đang xử lý)
                'iddc' => $iddc,  // Lưu giá trị iddc
                'idnv' => null, // Không có nhân viên xử lý, để giá trị null

            ]);
            //dd('dasd');
            foreach ($chitietgiohang as $ctgh) {
                foreach ($ctgh->chitietsanpham as $ctsp) {
                    ChiTietHoaDon::create([
                        'idctsp' => $ctsp->idctsp,
                        'idhd' => $hoadon->idhd, // ID đơn hàng
                        'soluong' => $ctgh->soluong,
                    ]);
                }
            }
            ChiTietGioHang::whereHas('giohang', function ($query) use ($idkh) {
                $query->where('idkh', $idkh);
            })->delete();

            // Lấy chi tiết đơn hàng từ bảng ChiTietDonHang
            $chitiethoadon = ChiTietHoaDon::with('chitietsanpham.sanpham', 'chitietsanpham.mau', 'chitietsanpham.kichthuoc')
                ->where('idhd', $hoadon->idhd)
                ->get();

            if ($phuongthuc->ten != 'VNPay') {

                Mail::to(auth()->user()->email)->send(new ThongBaoDonHangMail($hoadon, $chitiethoadon));
                return redirect()->route('trangchu')->with('success', 'Đặt hàng thành công!');
            } else {
                Mail::to(auth()->user()->email)->send(new ThongBaoDonHangMail($hoadon, $chitiethoadon));

                return $this->vnPayCheck($hoadon);
            }
        }

        return redirect()->route('dangnhap'); // Nếu người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập

    }

    public function vnPayCheck($hoadon)
    {

        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";

        $vnp_Returnurl = route('vnpayCallback', $hoadon);
        $vnp_TmnCode = "PFSP5PZI"; //Mã website tại VNPAY
        $vnp_HashSecret = "O5VK0S56M7FUUTUPASWHW0L68UDZG29E"; // Chuỗi bí mật
        $vnp_TxnRef = $hoadon->idhd; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này
        //        sang VNPAY
        $vnp_OrderInfo = 'Nizi';
        $vnp_OrderType = 'Thanh toán đơn hàng';
        $vnp_Amount = $hoadon->tongtien * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }
        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00',
            'message' => 'success',
            'data' => $vnp_Url
        );
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
        // vui lòng tham khảo thêm tại code demo

    }
    public function vnpayCallback(Request $request, $hoadon)
    {
        //dd($request->all, $donhang);
        $vnp_ResponseCode = $request->input('vnp_ResponseCode');
        $vnp_TransactionNo = $request->input('vnp_TransactionNo');
        //        $vnp_tongtien  = $request->input('vnp_Amount');
        if ($vnp_ResponseCode == '00') {
            return redirect()->route('trangchu')->with('success', 'Thanh toán thành công.');
        } else {
            $hoadonList = HoaDon::where('idhd', $hoadon)->first();
            //dd($donhangList);
            if ($hoadonList) {
                foreach ($hoadonList as $hoadon) {
                    foreach ($hoadon->chitiethoadon as $chitiethoadon) {
                        $chitiethoadon->delete();
                    }
                    $hoadon->delete();
                }
            }
            return redirect()->route('trangchu')->with('error', 'Hủy giao dịch thành công.');
        }
    }

  

}
