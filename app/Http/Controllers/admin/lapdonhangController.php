<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ChiTietDonHang;
use App\Models\ChiTietHoaDon;
use App\Models\ChiTietSanPham;
use App\Models\DiaChi;
use App\Models\DonHang;
use App\Models\HoaDon;
use App\Models\MaGiamGia;
use App\Models\KhachHang;
use App\Models\PhuongThucGiaoHang;
use App\Models\PhuongThucThanhToan;
use App\Models\TrangThaiDonHang;
use Carbon\Carbon;
use Illuminate\Http\Request;

class lapdonhangController extends Controller
{
    //trang lập đơn hàng
    public function show(Request $request)
    {
        $trangthaidonhang = TrangThaiDonHang::all();
        $giamgia = MaGiamGia::all();
        $chitiethoadon = ChiTietHoaDon::all();
        $cart = session()->get('cart', []);
        $totalQuantity = 0;
        $totalAmount = 0;

        foreach ($cart as $product) {
            $totalQuantity += $product['soluong'];
            $totalAmount += $product['total'];
        }
        return view('admin.lapdonhang', compact('trangthaidonhang', 'giamgia', 'chitiethoadon', 'totalQuantity', 'totalAmount', 'cart'));
    }

    //xóa sản phẩm của đơn hàng
    public function destroy($index)
    {
        // Lấy sản phẩm đã chọn từ session
        $cart = session('cart', []);

        // Kiểm tra xem có sản phẩm ở vị trí đó không
        if (isset($cart[$index])) {
            // Xóa sản phẩm khỏi giỏ hàng (session)
            unset($cart[$index]);

            // Cập nhật lại giỏ hàng trong session
            session()->put('cart', array_values($cart));
        }

        return redirect()->route('admin.lapdonhang'); // Quay lại trang lập đơn hàng
    }

    //cập nhật số lượng sản phẩm của đơn hàng
    public function update(Request $request, $idctsp)
{
    // Lấy dữ liệu từ session
    $cart = session('cart', []);
    
    // Tìm chi tiết sản phẩm trong cơ sở dữ liệu
    $chitietsanpham = ChiTietSanPham::find($idctsp);
    
    // Kiểm tra nếu không tìm thấy chi tiết sản phẩm
    if (!$chitietsanpham) {
        return redirect()->route('admin.lapdonhang')->with('error', 'Sản phẩm không tồn tại.');
    }

    // Lấy số lượng tồn kho của sản phẩm
    $soluongTonKho = $chitietsanpham->soluong;

    // Lấy số lượng người dùng nhập vào
    $soluongMoi = $request->input('soluong');

    // Kiểm tra nếu số lượng nhập vào lớn hơn số lượng tồn kho
    if ($soluongMoi > $soluongTonKho) {
        return redirect()->route('admin.lapdonhang')->with('error', 'Số lượng vượt quá tồn kho.');
    }

    // Tìm sản phẩm trong giỏ hàng theo idctsp
    foreach ($cart as &$product) {
        if ($product['idctsp'] == $idctsp) {
            // Cập nhật số lượng sản phẩm
            $product['soluong'] = $soluongMoi;
            $product['total'] = $product['soluong'] * $product['gia']; // Cập nhật tổng tiền
            break;
        }
    }

    // Cập nhật lại session giỏ hàng
    session(['cart' => $cart]);

    // Quay lại trang lập đơn hàng
    return redirect()->route('admin.lapdonhang');
}



    //lập đơn hàng
    public function store(Request $request)
{
    // Xác thực các trường bắt buộc
    $request->validate([
        'example' => 'nullable|string', // Tên khách hàng có thể null
        'diachi' => 'required|string|max:255', // Địa chỉ giao hàng là bắt buộc
    ]);

    // Kiểm tra nếu tên khách hàng được nhập vào
    $userName = $request->input('example');
    $diachi = $request->input('diachi');
    $sdt = $request->input('sdt');
    $phuongxa = $request->input('phuongxa');
    $quanhuyen = $request->input('quanhuyen');
    $tinhthanhpho = $request->input('tinhthanhpho');

    // Kiểm tra nếu khách hàng đã có trong DB không, nếu không thì tạo mới
    $khachhang = KhachHang::where('ten', $userName)->first();

    if (!$khachhang) {
        // Nếu khách hàng chưa có, tạo khách hàng mới
        $khachhang = KhachHang::create([
            'ten' => $userName,  // Lưu tên khách hàng
            'sdt' => $sdt,       // Số điện thoại
            'email' => null,     // Có thể bổ sung email nếu cần
            'matkhau' => null,   // Nếu không cần mật khẩu
            'block' => null,   // Nếu không cần mật khẩu

        ]);
    }
     
    // Tạo hoặc lấy địa chỉ giao hàng
    $diachiGiaoHang = DiaChi::where('diachi', $diachi)->where('idkh', $khachhang->idkh)->first();

    if (!$diachiGiaoHang) {
        // Nếu không có địa chỉ, tạo mới
        $diachiGiaoHang = DiaChi::create([
            'tennguoinhan' => $khachhang->ten,  // Gán tên khách hàng vào trường tennguoinhan
            'sdt' => $sdt,        // Số điện thoại
            'diachi' => $diachi,
            'phuongxa' => $phuongxa,
            'quanhuyen' => $quanhuyen,
            'tinhthanhpho' => $tinhthanhpho,
            'idkh' => $khachhang->idkh, // Gán id khách hàng
        ]);
    }

    // Lấy tên người nhận từ bảng DiaChi
    $tennguoinhan = $diachiGiaoHang->tennguoinhan;
    $idkh = $khachhang->idkh;
    // Lấy thông tin trạng thái đơn hàng
    $trangthai = TrangThaiDonHang::find($request->input('trangthai'));

    // Lấy idpttt từ bảng PhuongThucThanhToan
    $idpttt = PhuongThucThanhToan::where('ten', 'Tại cửa hàng')->first()->idpttt;

    // Lấy idptgh từ bảng PhuongThucGiaoHang
    $idptgh = PhuongThucGiaoHang::where('ten', 'Tại cửa hàng')->first()->idptgh;

    $idttdh = TrangThaiDonHang::where('ten', 'Mua hàng thành công')->first()->idttdh;

    // Tính tổng tiền từ giỏ hàng
    $cart = session()->get('cart', []);
    $totalAmount = 0;

    foreach ($cart as $item) {
        $totalAmount += $item['gia'] * $item['soluong']; // Giả sử mỗi sản phẩm có giá và số lượng
    }

    $idnv = auth()->guard('nhanvien')->id(); // Đảm bảo nhân viên đã đăng nhập

    // Thực hiện lưu thông tin đơn hàng
    $hoadon = new HoaDon([
        'tennguoinhan' => $tennguoinhan, // Lưu tên người nhận
        'tongtien' => $totalAmount, // Lưu tổng tiền
        'ngaylap' => Carbon::now('Asia/Ho_Chi_Minh'),
        'ngaydathang' => Carbon::now('Asia/Ho_Chi_Minh'),
        'ngaynhanhang' => Carbon::now('Asia/Ho_Chi_Minh'),
        'idgg' => null, // Không có mã giảm giá
        'idkh' => $idkh, // Không có mã giảm giá

        'idpttt' => $idpttt,  // Lưu idpttt thay vì 'Tại cửa hàng'
        'idttdh' => $idttdh,
        'iddc' => $diachiGiaoHang->iddc, // Gán địa chỉ giao hàng cho đơn hàng
        'idptgh' => $idptgh, // Lưu idptgh thay vì 'Tại cửa hàng'
        'idnv' => $idnv, // Lưu id nhân viên
    ]);

    $hoadon->save();

    // Xử lý giỏ hàng và chi tiết đơn hàng
    foreach ($cart as $item) {
        // Lưu chi tiết đơn hàng
        $chitiethoadon = new ChiTietHoaDon();
        $chitiethoadon->idhd = $hoadon->idhd;
        $chitiethoadon->idctsp = $item['idctsp'];
        $chitiethoadon->soluong = $item['soluong'];
        $chitiethoadon->save();

        // Cập nhật số lượng sản phẩm trong ChiTietSanPham
        $chitietsanpham = ChiTietSanPham::find($item['idctsp']);
        if ($chitietsanpham) {
            $chitietsanpham->soluong -= $item['soluong']; // Giảm số lượng
            $chitietsanpham->save(); // Lưu lại thay đổi
        }
    }

    // Xóa giỏ hàng
    session()->forget('cart');

    return redirect()->route('admin.hoadon')->with('success', 'Lập đơn hàng thành công');
}

    
}
