<?php

namespace App\Http\Controllers\account;

use App\Http\Controllers\Controller;
use App\Models\LoaiTinTuc;
use App\Models\KhachHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth để xử lý đăng nhập
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ResetPasswordMail;
use App\Models\ChiTietDonHang;
use App\Models\ChiTietGioHang;
use App\Models\DanhMucSanPham;
use App\Models\DiaChi;
use App\Models\HoaDon;
use App\Models\NhanVien;
use App\Models\PhuongThucGiaoHang;
use App\Models\TrangThaiDonHang;

class LoginController extends Controller
{
    
    public function dangnhap()
    {
        $danhmucsanpham = DanhMucSanPham::all();
        $loaitintuc = LoaiTinTuc::all();
        if (auth()->check()) {
            $idkh = auth()->user()->idkh;

            $chitietgiohang = ChiTietGioHang::with('chitietsanpham.sanpham')
                ->whereHas('giohang', function ($query) use ($idkh) {
                    $query->where('idkh', $idkh);
                })
                ->get();

            $tongTien = 0;
            $soLuongSanPham = 0;

            foreach ($chitietgiohang as $ctgh) {
                foreach ($ctgh->chitietsanpham as $ctsp) {
                    $giaSanPham = $ctsp->sanpham->gia;

                    if ($ctsp->sanpham->giamgia && $ctsp->sanpham->giamgia->phantram > 0) {
                        $giaSanPham -= ($giaSanPham * $ctsp->sanpham->giamgia->phantram) / 100;
                    }

                    $tongTien += $giaSanPham * $ctgh->soluong;
                    $soLuongSanPham += $ctgh->soluong;
                }
            }
            return redirect()->route('trangchu'); 

        } else {
            $chitietgiohang = session('giohang', []);

            $tongTien = 0; 
            $soLuongSanPham = 0; 

            foreach ($chitietgiohang as $item) {
                if (isset($item['sanpham']) && $item['sanpham'] instanceof \App\Models\ChiTietSanPham) {
                    $sanpham = $item['sanpham']; 

                    $giaSanPham = $sanpham->sanpham->gia ?? 0;

                    if (isset($sanpham->sanpham->giamgia) && $sanpham->sanpham->giamgia->phantram > 0) {
                        $giaSanPham -= ($giaSanPham * $sanpham->sanpham->giamgia->phantram) / 100;
                    }

                    $tongTien += $giaSanPham * $item['soluong'];
                    $soLuongSanPham += $item['soluong'];
                }
            }

            return view('taikhoan.dangnhap', compact('danhmucsanpham', 'loaitintuc', 'chitietgiohang', 'tongTien', 'soLuongSanPham'));
        }
    }

    public function xulyDangNhap(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('trangchu'); 
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $khachhang = KhachHang::where('email', $request->email)->first();

        if (!$khachhang) {
            return back()->withErrors(['email' => 'Email không hợp lệ.']);
        }

        if (!Hash::check($credentials['password'], $khachhang->matkhau)) {
            return back()->withErrors([
                'matkhau' => 'Mật khẩu không chính xác.',
            ])->onlyInput('email');
        }

        Auth::login($khachhang, $request->has('remember'));
        $request->session()->regenerate();

        if ($khachhang->block == 1) {
            Auth::logout();
            return redirect()->route('trangchu')->withErrors(['error' => 'Tài khoản của bạn đã bị khóa.']);
        }
        
        Session::put('userName', $khachhang->ten);
        Session::put('email', $khachhang->email);
        Session::put('sdt', $khachhang->sdt);

        return redirect()->intended(route('trangchu'))->with('success', 'Đăng nhập thành công.'); 

    }








    public function dangky()
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
            return redirect()->route('trangchu'); // Chuyển hướng về trang chủ nếu đã đăng nhập

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
            return view('taikhoan.dangky', compact('danhmucsanpham', 'loaitintuc', 'chitietgiohang', 'tongTien', 'soLuongSanPham'));
        }
    }
    public function xulyDangKy(Request $request)
    {
        // Validate dữ liệu nhập vào
        $request->validate([
            'ten' => 'required|string|max:100',
            'sdt' => ['required', 'regex:/^0[35789]\d{8}$/'],
            'email' => 'required|email|unique:khachhang,email',
            'matkhau' => 'required|string|min:6|confirmed',


        ]);

        // Tạo người dùng mới
        $khachhang = new KhachHang();
        $khachhang->ten = $request->ten;
        $khachhang->sdt = $request->sdt;
        $khachhang->email = $request->email;
        $khachhang->matkhau = Hash::make($request->matkhau); // Mã hóa mật khẩu
        $khachhang->block = 0; // Mã hóa mật khẩu

        $khachhang->save();

        // Chuyển hướng về trang đăng nhập với thông báo thành công
        return redirect()->route('dangnhap')->with('success', 'Đăng ký thành công! Bạn có thể đăng nhập ngay bây giờ.');
    }
    public function quenmatkhau()
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
            return redirect()->route('trangchu'); // Chuyển hướng về trang chủ nếu đã đăng nhập

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
            return view('taikhoan.quenmatkhau', compact('danhmucsanpham', 'loaitintuc', 'chitietgiohang', 'tongTien', 'soLuongSanPham'));
        }
    }


    public function xulyQuenMatKhau(Request $request)
    {
        // Xác thực email
        $request->validate([
            'email' => 'required|email|exists:khachhang,email',
        ]);

        // Lấy email từ request
        $email = $request->email;

        // Tạo token ngẫu nhiên
        $token = Str::random(60);

        // Gửi email khôi phục mật khẩu
        $url = url('reset-password?token=' . $token . '&email=' . $email);
        Mail::to($email)->send(new ResetPasswordMail($url));

        // Trả về thông báo
        return back()->with('status', 'Email đặt lại mật khẩu đã được gửi đến gmail của bạn.');
    }

    public function showResetForm(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');
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
        } else {
            // Nếu người dùng chưa đăng nhập, giỏ hàng sẽ trống và tổng tiền bằng 0
            $chitietgiohang = [];
            $tongTien = 0;
            $soLuongSanPham = 0;
        }
        return view('taikhoan.resetmatkhau', ['token' => $token, 'email' => $email], compact('danhmucsanpham', 'loaitintuc', 'chitietgiohang', 'tongTien', 'soLuongSanPham'));
    }

    public function resetPassword(Request $request)
    {
        // Xác thực dữ liệu từ form
        $request->validate([
            'password' => 'required|min:6|confirmed', // Kiểm tra mật khẩu và xác nhận
            'token' => 'required'
        ], [
            // Tùy chỉnh thông báo lỗi
            'matkhau.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'matkhau.confirmed' => 'Xác nhận mật khẩu không khớp với mật khẩu.',
        ]);

        // Lấy email từ request
        $email = $request->email;

        // Tìm người dùng bằng email
        $user = khachhang::where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'Email không tồn tại.']);
        }

        // Cập nhật mật khẩu mới
        $user->matkhau = Hash::make($request->password);
        $user->save();

        return redirect()->route('dangnhap')->with('status', 'Mật khẩu đã được đặt lại thành công.');
    }

    public function dangxuat(Request $request)
    {
        Session::flush();
        return redirect('/dangnhap');
    }


    public function thongtin()
    {
        // Giả sử bạn lưu email người dùng trong session khi họ đăng nhập
        $email = Session::get('email'); // Hoặc lấy từ session nếu đã lưu

        // Kiểm tra nếu email tồn tại
        if (!$email) {
            return redirect()->route('dangnhap'); // Nếu không có email, chuyển hướng về trang đăng nhập
        }

        // Tìm người dùng theo email
        $khachhang = KhachHang::where('email', $email)->first();

        // Kiểm tra nếu người dùng tồn tại
        if (!$khachhang) {
            return redirect()->route('dangnhap')->withErrors(['email' => 'Người dùng không tồn tại.']);
        }

        // Lấy danh sách loại sản phẩm và loại tin tức
        $danhmucsanpham = DanhMucSanPham::all();
        $loaitintuc = LoaiTinTuc::all();
        $diachi = DiaChi::where('idkh', $khachhang->idkh)->get();

        if (auth()->check()) {
            $idkh = auth()->user()->idkh;

            // Lấy tất cả các thông tin đơn hàng của người dùng
            $hoadon = HoaDon::where('idkh', $idkh)
                ->orderBy('ngaydathang', 'desc')
                ->with(['chitiethoadon.chitietsanpham.sanpham', 'chitiethoadon.chitietsanpham.mau', 'chitiethoadon.chitietsanpham.kichthuoc'])
                ->get();




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
        } else {
            // Nếu người dùng chưa đăng nhập, giỏ hàng sẽ trống và tổng tiền bằng 0
            $chitietgiohang = [];
            $tongTien = 0;
            $soLuongSanPham = 0;
        }
        // Truyền thông tin người dùng vào view
        return view('client.thongtin', compact('danhmucsanpham', 'loaitintuc', 'khachhang', 'diachi', 'chitietgiohang', 'tongTien', 'soLuongSanPham', 'hoadon'));
    }

    public function capNhatTen(Request $request, $idkh)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'ten' => 'required|string|max:255',
        ]);

        // Tìm và cập nhật tên của người dùng
        $khachhang = KhachHang::findOrFail($idkh);
        $khachhang->ten = $request->ten;
        $khachhang->save();

        return redirect()->back()->with('success', 'Cập nhật tên thành công!');
    }

    // Cập nhật số điện thoại
    public function capNhatSoDienThoai(Request $request, $idkh)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'sdt' => 'required|digits:10', // Số điện thoại phải có đúng 10 chữ số
        ]);

        // Tìm và cập nhật số điện thoại của người dùng
        $khachhang = KhachHang::findOrFail($idkh);
        $khachhang->sdt = $request->sdt;
        $khachhang->save();

        return redirect()->back()->with('success', 'Cập nhật số điện thoại thành công!');
    }

    // Cập nhật mật khẩu
    public function capNhatMatKhau(Request $request, $idkh)
    {
        $request->validate([
            'matkhau_cu' => 'required',
            'matkhau_moi' => 'required|min:6|confirmed',
        ]);

        $khachhang = KhachHang::findOrFail($idkh);

        // Kiểm tra mật khẩu cũ
        if (!Hash::check($request->matkhau_cu, $khachhang->matkhau)) {
            // Nếu không đúng, trả về lỗi
            return redirect()->back()->withErrors(['matkhau_cu' => 'Mật khẩu cũ không đúng!']);
        }

        // Nếu mật khẩu cũ đúng, cập nhật mật khẩu mới
        $khachhang->matkhau = Hash::make($request->matkhau_moi);
        $khachhang->save();

        return redirect()->back()->with('success', 'Cập nhật mật khẩu thành công!');
    }

    public function huyDonHang(Request $request, $idhd)
    {
        // Kiểm tra đơn hàng tồn tại
        $hoadon = HoaDon::find($idhd);

        if (!$hoadon) {
            return redirect()->back()->with('error', 'Hóa đơn không tồn tại.');
        }

        // Kiểm tra trạng thái "Chờ xác nhận"
        $trangThaiChoXacNhan = TrangThaiDonHang::where('ten', 'Chờ xác nhận')->first();
        if (!$trangThaiChoXacNhan || $hoadon->idttdh != $trangThaiChoXacNhan->idttdh) {
            return redirect()->back()->with('error', 'Đơn hàng không thể hủy.');
        }

        // Lấy ID trạng thái "Đã hủy"
        $trangThaiDaHuy = TrangThaiDonHang::where('ten', 'Đã hủy')->first();
        if (!$trangThaiDaHuy) {
            return redirect()->back()->with('error', 'Trạng thái "Đã hủy" không tồn tại.');
        }

        // Cập nhật trạng thái đơn hàng
        $hoadon->idttdh = $trangThaiDaHuy->idttdh;
        $hoadon->save();

        return redirect()->back()->with('success', 'Đơn hàng đã được hủy thành công.');
    }

    
}
