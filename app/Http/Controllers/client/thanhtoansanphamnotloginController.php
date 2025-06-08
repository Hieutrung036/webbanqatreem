<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Mail\ThongBaoDonHangMail;
use App\Mail\ThongBaoDonHangNotLoginMail;
use App\Models\ChiTietGioHang;
use App\Models\ChiTietHoaDon;
use App\Models\DanhMucSanPham;
use App\Models\DiaChi;
use App\Models\HoaDon;
use App\Models\KhachHang;
use App\Models\LoaiSanPham;
use App\Models\LoaiTinTuc;
use App\Models\MaGiamGia;
use App\Models\PhuongThucGiaoHang;
use App\Models\PhuongThucThanhToan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class thanhtoansanphamnotloginController extends Controller
{
    public function index(Request $request)
    {
        // Lấy thông tin các loại sản phẩm và tin tức
        $loaisanpham = LoaiSanPham::all();
        $loaitintuc = LoaiTinTuc::all();
        $danhmucsanpham = DanhMucSanPham::all();

        // Lấy thông tin giỏ hàng từ session
        $chitietgiohang = session('giohang', []);

        // Lấy các phương thức giao hàng
        $phuongthucgiaohang = PhuongThucGiaoHang::all();

        // Đảm bảo giỏ hàng luôn hiển thị, không cần kiểm tra người dùng đăng nhập
        $user = null; // Không có thông tin người dùng
        $diachi = []; // Không có thông tin địa chỉ
        $phuongthucthanhtoan = PhuongThucThanhToan::all();

        // Tính tổng tiền trước khi giảm giá
        $tongTien = 0; // Tổng tiền cơ bản
        $tongTienGG = 0; // Tổng tiền sau giảm giá
        $tongTienShip = 0; // Tổng tiền cuối cùng
        $soLuongSanPham = 0;

        $chitietgiohang = session('giohang', []);

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

        // Xử lý mã giảm giá nếu có
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
            $tongTienShip = $tongTienGG + $phuongthucgiaohangSelected->phigiaohang; // Sử dụng $tongTienGG

            return response()->json([
                'tongTienShip' => number_format($tongTienShip, 0, ',', '.'),
            ]);
        }


        // Nếu yêu cầu AJAX, trả về JSON với các giá trị tính toán
        if ($request->ajax()) {
            $idPhuongThuc = $request->input('phuongthucvanchuyen');
            $phuongthucgiaohangSelected = PhuongThucGiaoHang::find($idPhuongThuc);

            if ($phuongthucgiaohangSelected) {
                $tongTienShip = $tongTien + $phuongthucgiaohangSelected->phigiaohang;

                return response()->json([
                    'tongTienShip' => number_format($tongTienShip, 0, ',', '.'),
                ]);
            }

            return response()->json([
                'error' => 'Không tìm thấy phương thức vận chuyển.',
            ], 400);
        }


        // Trả về view với thông tin tính toán
        return view('client.thanhtoansanphamnotlogin', compact(
            'loaisanpham',
            'loaitintuc',
            'chitietgiohang',
            'tongTien',
            'tongTienShip',
            'soLuongSanPham',
            'phuongthucgiaohang',
            'phuongthucthanhtoan',
            'user', // Vẫn truyền vào view nhưng là null
            'diachi', // Không có địa chỉ
            'danhmucsanpham',
            'voucherDiscount' // Truyền discount voucher vào view để hiển thị
        ));
    }

    public function xulythanhtoan(Request $request)
    {
        // Lấy thông tin khách hàng từ form
        $tennguoinhan = $request->input('tennguoinhan');
        $email = $request->input('email');
        $sdt = $request->input('sdt');
        $diachi = $request->input('diachi');
        $phuongxa = $request->input('phuongxa');
        $quanhuyen = $request->input('quanhuyen');
        $tinhthanhpho = $request->input('tinhthanhpho');

        // Kiểm tra nếu số điện thoại không hợp lệ
        if (empty($sdt)) {
            return redirect()->back()->with('error', 'Số điện thoại không được để trống.');
        }

        // Kiểm tra nếu giỏ hàng trống
        $chitietgiohang = session('giohang', []);
        if (empty($chitietgiohang)) {
            return redirect()->route('giohang')->with('error', 'Giỏ hàng của bạn hiện tại trống.');
        }

        // Tính toán tổng tiền
        $tongTien = 0;
        $tongTienGG = 0;
        $tongTienShip = 0;
        $soLuongSanPham = 0;
        
        
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

        // Áp dụng mã giảm giá nếu có
        $voucherCode = $request->input('voucherCode');
        $voucherDiscount = 0;
        $idgg = null;

        if ($voucherCode) {
            $magiamgia = MaGiamGia::where('code', $voucherCode)->first();
            if ($magiamgia) {
                $voucherDiscount = $magiamgia->phantram;
                $idgg = $magiamgia->idgg;
            }
        }
        $tongTienGG = $tongTien - ($tongTien * $voucherDiscount / 100);

        // Tính phí vận chuyển
        $idPhuongThuc = $request->input('phuongthucvanchuyen');
        $phuongthucgiaohangSelected = PhuongThucGiaoHang::find($idPhuongThuc);

        if ($phuongthucgiaohangSelected) {
            $tongTienShip = $tongTienGG + $phuongthucgiaohangSelected->phigiaohang;
        } else {
            $tongTienShip = $tongTienGG;
        }

        // Lấy phương thức thanh toán
        $idpttt = $request->input('idpttt');
        $phuongthuc = PhuongThucThanhToan::find($idpttt);

        if (!$phuongthuc) {
            return redirect()->back()->with('error', 'Vui lòng chọn phương thức thanh toán.');
        }

        $idptgh = $phuongthucgiaohangSelected ? $phuongthucgiaohangSelected->idptgh : null;
        $ngayNhanHang = Carbon::now('Asia/Ho_Chi_Minh')->addDays($phuongthucgiaohangSelected->ngaydukien ?? 0);

        // Kiểm tra địa chỉ giao hàng và thêm vào bảng diachi
        $diachiModel = DiaChi::create([
            'tennguoinhan' => $tennguoinhan,
            'sdt' => $sdt,
            'diachi' => $diachi,
            'phuongxa' => $phuongxa,
            'quanhuyen' => $quanhuyen,
            'tinhthanhpho' => $tinhthanhpho
        ]);

       
            $khachhang = KhachHang::create([
                'ten' => $tennguoinhan,
                'email' => $email,
                'sdt' => $sdt,
                'matkhau' => null,
                'block' => null,
                // Các thông tin khác nếu cần
            ]);
        
        // Lấy iddc từ địa chỉ vừa thêm
        $iddc = $diachiModel->iddc;
        $idkh = $khachhang->idkh;
        // Tạo hóa đơn
        $hoadon = HoaDon::create([
            'idkh' => $idkh,
            'tongtien' => $tongTienShip,
            'ngaydathang' => Carbon::now('Asia/Ho_Chi_Minh'),
            'ngaylap' => null,
            'ngaynhanhang' => $ngayNhanHang,
            'idgg' => $idgg,
            'idpttt' => $idpttt,
            'idptgh' => $idptgh,
            'idttdh' => 1,
            'iddc' => $iddc, // Sử dụng iddc của địa chỉ mới
            'idnv' => null,
        ]);

        // Thêm chi tiết hóa đơn
        // Lấy giỏ hàng từ session

        $chitietgiohang = session('giohang', []); // Lấy giỏ hàng từ session

        foreach ($chitietgiohang as $ctgh) {
            // Kiểm tra nếu 'sanpham' tồn tại và là đối tượng hoặc mảng
            if (isset($ctgh['sanpham'])) {
                $sanpham = $ctgh['sanpham']; // Lấy sản phẩm trong giỏ hàng

                // Kiểm tra nếu sản phẩm có thuộc tính 'idctsp'
                if (isset($sanpham->idctsp)) {
                    // Lưu chi tiết hóa đơn vào bảng ChiTietHoaDon
                    ChiTietHoaDon::create([
                        'idctsp' => $sanpham->idctsp,  // ID chi tiết sản phẩm
                        'idhd' => $hoadon->idhd,       // ID hóa đơn
                        'soluong' => $ctgh['soluong'], // Số lượng sản phẩm
                    ]);
                }
            }
        }


        $chiTietHoaDon = ChiTietHoaDon::with('chitietsanpham.sanpham', 'chitietsanpham.mau', 'chitietsanpham.kichthuoc')
            ->where('idhd', $hoadon->idhd)
            ->get();


        // Kiểm tra phương thức thanh toán
        if ($phuongthuc->ten != 'VNPay') {
            Mail::to($email)->send(new ThongBaoDonHangNotLoginMail($hoadon, $chiTietHoaDon));

            return redirect()->route('trangchu')->with('success', 'Đặt hàng thành công!');
        } else {
            Mail::to($email)->send(new ThongBaoDonHangNotLoginMail($hoadon, $chiTietHoaDon));

            return $this->vnPayCheck($hoadon);
        }
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
