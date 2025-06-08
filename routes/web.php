<?php

use App\Exports\HoaDonExport;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\client;
use App\Http\Controllers\account;
use App\Http\Controllers\admin;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', [client\trangchuController::class, 'index'])->name('trangchu');
Route::get('/lien-he', [client\lienheController::class, 'index'])->name('lienhe');
Route::get('/chat', [client\chatController::class, 'index'])->name('client.chat');
Route::post('/chat/send', [client\chatController::class, 'send'])->name('client.chat.send');


Route::get('/gioi-thieu', [client\gioithieuController::class, 'index'])->name('gioithieu');

Route::get('/xemnhanh/{id}', [client\trangchuController::class, 'xemnhanh'])->name('quickview');


Route::get('/tin-tuc', [client\tintucController::class, 'index'])->name('tintuc');
Route::get('/tin-tuc/{ten}', [client\tintucController::class, 'showByType'])->name('tintuc.type');
Route::get('/tin-tuc/{ten}/{tieude}', [client\tintucController::class, 'show'])->name('chitiettintuc');
// Route::get('/tin-tuc/{ten}/{slug}', [client\tintucController::class, 'show'])->name('chitiettintuc');

Route::get('/quan-ao-be-trai', [client\sanphamController::class, 'sanphambetrai'])->name('sanpham.be_trai');
Route::get('/quan-ao-be-gai', [client\sanphamController::class, 'sanphambegai'])->name('sanpham.be_gai');
Route::get('/san-pham-moi', [client\sanphamController::class, 'sanphammoi'])->name('sanpham.moi');
Route::get('/san-pham-noi-bat', [client\sanphamController::class, 'sanphamnoibat'])->name('sanpham.noibat');
Route::get('/san-pham/{slug}', [client\chitietsanphamController::class, 'index'])->name('chitietsanpham');

Route::get('/quan-ao-be-gai/{ten}', [client\sanphamController::class, 'loaisanphambegai'])->name('sanpham.be_gai.loai');
Route::get('/quan-ao-be-trai/{ten}', [client\sanphamController::class, 'loaisanphambetrai'])->name('sanpham.be_trai.loai');

Route::get('/check-stock', [client\chitietsanphamController::class, 'checkStock']);
Route::post('/check-stock1', [client\chitietsanphamController::class, 'checkStock1'])->name('checkStock1');


Route::get('/thanh-toan-san-pham', [client\thanhtoansanphamController::class, 'index'])->name('thanhtoansanpham');
Route::post('/thanh-toan-san-pham-1', [client\thanhtoansanphamController::class, 'xulythanhtoan'])->name('xulythanhtoan');
Route::get('/vnpay/callback/{donhang}', [client\thanhtoansanphamController::class, 'vnpayCallback'])->name('vnpayCallback');

Route::get('/thah-toan-san-pham', [client\thanhtoansanphamnotloginController::class, 'index'])->name('thanhtoansanphamnotlogin');
Route::post('/thah-toan-san-pham-1', [client\thanhtoansanphamnotloginController::class, 'xulythanhtoan'])->name('xulythanhtoannotlogin');

Route::get('/gio-hang', [client\giohangController::class, 'index'])->name('giohang');
// Route::get('/gio-hang', [client\giohangnologinController::class, 'index'])->name('giohangkhongdangnhap');

Route::post('/gio-hang', [client\giohangController::class, 'store'])->name('giohang.store');
Route::post('/gio-hang/update', [client\giohangController::class, 'update'])->name('giohang.update');
Route::post('/giohang/update-session', [client\giohangController::class, 'updateSeassion'])->name('giohang.updatesession');

Route::delete('/gio-hang/xoa/{id}', [client\giohangController::class, 'destroy'])->name('giohang.destroy');

Route::post('/gio-hang/delete-selected', [client\giohangController::class, 'deleteSelected'])->name('giohang.deleteSelected');

Route::post('/dat-hang', [client\dathangController::class, 'index'])->name('dathang');

Route::get('getVoucherDiscount', [client\dathangController::class, 'getDiscount'])->name('getVoucherDiscount');

Route::post('/dat-hang/dat-hang-1', [client\dathangController::class, 'xulydathang'])->name('xulydathang');

Route::post('/dat-hag/dat-hang-1', [client\dathangnotloginController::class, 'xulydathangnotlogin'])->name('xulydathangnotlogin');



Route::get('/dangnhap', [account\loginController::class, 'dangnhap'])->name('dangnhap');

Route::post('/dangnhap', [account\loginController::class, 'xulyDangNhap'])->name('dangnhap.submit');

Route::get('/dangky', [account\loginController::class, 'dangky'])->name('dangky');
Route::post('/dangky', [account\loginController::class, 'xulyDangKy'])->name('dangky.submit');

Route::get('/quenmatkhau', [account\loginController::class, 'quenmatkhau'])->name('quenmatkhau');
Route::post('/xulyquenmatkhau', [account\loginController::class, 'xulyQuenMatKhau'])->name('xulyQuenMatKhau');

Route::get('/reset-password', [account\LoginController::class, 'showResetForm'])->name('reset.form');
Route::post('/reset-password', [account\LoginController::class, 'resetPassword'])->name('resetPassword');
Route::get('/dangxuat', [account\LoginController::class, 'dangxuat'])->name('dangxuat');
Route::get('/thongtin', [account\LoginController::class, 'thongtin'])->name('thongtin');

Route::post('/capnhat-ten/{idkh}', [account\LoginController::class, 'capNhatTen'])->name('capnhat.ten');
Route::post('/capnhat-sdt/{idkh}', [account\LoginController::class, 'capNhatSoDienThoai'])->name('capnhat.sdt');
Route::post('/capnhat-matkhau/{idkh}', [account\LoginController::class, 'capNhatMatKhau'])->name('capnhat.matkhau');

Route::post('/diachi/them/{idkh}', [client\diachiController::class, 'store'])->name('diachi.store');
Route::put('/diachi/{idkh}', [client\diachiController::class, 'update'])->name('diachi.update');
Route::delete('/diachi/{iddc}', [client\diachiController::class, 'destroy'])->name('diachi.destroy');
Route::post('/diachi/{iddc}', [client\diachiController::class, 'update'])->name('diachi.update');
Route::put('/diachi/{iddc}', [client\diachiController::class, 'update'])->name('diachi.update');

Route::post('/hoadon/huy/{idhd}', [account\loginController::class, 'huyDonHang'])->name('hoadon.huy');
Route::get('/tim-kiem', [client\timkiemController::class, 'timKiem'])->name('client.timkiem');
Route::get('/kiem-tra-don-hang', [client\kiemtradonhangController::class, 'index'])->name('kiemtradonhang');

Route::post('/kiem-tra-don-hang1', [client\kiemtradonhangController::class, 'kiemTraDonHang'])->name('hoadon.kiemtra');
Route::get('/hoadon/chitiet/{orderId}', [client\kiemtradonhangController::class, 'chiTietDonHang'])->name('hoadon.chitiet');


Route::get('/danhgia/create/{idhd}', [client\danhgiaController::class, 'index'])->name('danhgia.create');
Route::post('/danhgia/them', [client\danhgiaController::class, 'store'])->name('danhgia.them');

Route::post('/hoan-tien/{id}', [client\hoantienController::class, 'store'])->name('hoan-tien.store');

Route::post('/them-vao-gio-hang', [client\trangchuController::class, 'addToCart']);


// Route::post('/logout', [account\loginController::class, 'logout'])->name('logout');

Route::get('/admin/login', [admin\LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [admin\LoginController::class, 'login'])->name('admin.login');

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/trangchu', [admin\trangchuController::class, 'index'])->name('admin.trangchu');

    // Route cho trang chat
    Route::get('/admin/chat', [admin\ChatController::class, 'index'])->name('admin.chat');

    Route::get('/admin/chat/{idkh}', [admin\ChatController::class, 'show'])->name('chat.show');
    Route::post('/admin/chat/send', [admin\ChatController::class, 'send'])->name('chat.send');




    Route::get('/admin/khachhang', [admin\khachhangController::class, 'index'])->name('admin.khachhang');
    Route::post('/admin/khachhang/them', [admin\khachhangController::class, 'store'])->name('admin.khachhang.store');
    Route::put('admin/khachhang/block/{id}', [admin\khachhangController::class, 'block'])->name('admin.khachhang.block');

    Route::post('/admin/khachhang/{idkh}', [admin\khachhangController::class, 'update'])->name('admin.khachhang.update');
    Route::put('/admin/khachhang/{idkh}', [admin\khachhangController::class, 'update'])->name('admin.khachhang.update');
    Route::get('/admin/khachhang/search', [admin\khachhangController::class, 'search'])->name('admin.khachhang.search');

    Route::get('/admin/diachi', [admin\diachiController::class, 'index'])->name('admin.diachi');
    Route::post('/admin/diachi/them', [admin\diachiController::class, 'store'])->name('admin.diachi.store');
    Route::delete('/admin/diachi/{iddc}', [admin\diachiController::class, 'destroy'])->name('admin.diachi.destroy');
    Route::post('/admin/diachi/{iddc}', [admin\diachiController::class, 'update'])->name('admin.diachi.update');
    Route::put('/admin/diachi/{iddc}', [admin\diachiController::class, 'update'])->name('admin.diachi.update');
    Route::get('/admin/diachi/search', [admin\diachiController::class, 'search'])->name('admin.diachi.search');


    Route::get('/admin/danhgia', [admin\danhgiaController::class, 'index'])->name('admin.danhgia');
    Route::post('/admin/danhgia/them', [admin\danhgiaController::class, 'store'])->name('admin.danhgia.store');
    Route::delete('/admin/danhgia/{iddg}', [admin\danhgiaController::class, 'destroy'])->name('admin.danhgia.destroy');
    Route::get('/admin/danhgia/search', [admin\danhgiaController::class, 'search'])->name('admin.danhgia.search');


    Route::get('/admin/sanpham', [admin\sanphamController::class, 'index'])->name('admin.sanpham');
    Route::post('/admin/sanpham/them', [admin\sanphamController::class, 'store'])->name('admin.sanpham.store');
    Route::delete('/admin/sanpham/{idsp}', [admin\sanphamController::class, 'destroy'])->name('admin.sanpham.destroy');
    Route::post('/admin/sanpham/{idsp}', [admin\sanphamController::class, 'update'])->name('admin.sanpham.update');
    Route::put('/admin/sanpham/{idsp}', [admin\sanphamController::class, 'update'])->name('admin.sanpham.update');
    Route::get('/admin/sanpham/search', [admin\sanphamController::class, 'search'])->name('admin.sanpham.search');


    Route::get('/admin/loaisanpham', [admin\loaisanphamController::class, 'index'])->name('admin.loaisanpham');
    Route::post('/admin/loaisanpham/them', [admin\loaisanphamController::class, 'store'])->name('admin.loaisanpham.store');
    Route::delete('/admin/loaisanpham/{idlsp}', [admin\loaisanphamController::class, 'destroy'])->name('admin.loaisanpham.destroy');
    Route::post('/admin/loaisanpham/{idlsp}', [admin\loaisanphamController::class, 'update'])->name('admin.loaisanpham.update');
    Route::put('/admin/loaisanpham/{idlsp}', [admin\loaisanphamController::class, 'update'])->name('admin.loaisanpham.update');
    Route::get('/admin/loaisanpham/search', [admin\loaisanphamController::class, 'search'])->name('admin.loaisanpham.search');


    Route::get('/admin/mau', [admin\mauController::class, 'index'])->name('admin.mau');
    Route::post('/admin/mau/them', [admin\mauController::class, 'store'])->name('admin.mau.store');
    Route::delete('/admin/mau/{idm}', [admin\mauController::class, 'destroy'])->name('admin.mau.destroy');
    Route::post('/admin/mau/{idm}', [admin\mauController::class, 'update'])->name('admin.mau.update');
    Route::put('/admin/mau/{idm}', [admin\mauController::class, 'update'])->name('admin.mau.update');
    Route::get('/admin/mau/search', [admin\mauController::class, 'search'])->name('admin.mau.search');

    Route::get('/admin/loaitintuc', [admin\loaitintucController::class, 'index'])->name('admin.loaitintuc');
    Route::post('/admin/loaitintuc/them', [admin\loaitintucController::class, 'store'])->name('admin.loaitintuc.store');
    Route::delete('/admin/loaitintuc/{idltt}', [admin\loaitintucController::class, 'destroy'])->name('admin.loaitintuc.destroy');
    Route::post('/admin/loaitintuc/{idltt}', [admin\loaitintucController::class, 'update'])->name('admin.loaitintuc.update');
    Route::put('/admin/loaitintuc/{idltt}', [admin\loaitintucController::class, 'update'])->name('admin.loaitintuc.update');
    Route::get('/admin/loaitintuc/search', [admin\loaitintucController::class, 'search'])->name('admin.loaitintuc.search');

    Route::get('/admin/kichthuoc', [admin\kichthuocController::class, 'index'])->name('admin.kichthuoc');
    Route::post('/admin/kichthuoc/them', [admin\kichthuocController::class, 'store'])->name('admin.kichthuoc.store');
    Route::delete('/admin/kichthuoc/{idkt}', [admin\kichthuocController::class, 'destroy'])->name('admin.kichthuoc.destroy');
    Route::post('/admin/kichthuoc/{idkt}', [admin\kichthuocController::class, 'update'])->name('admin.kichthuoc.update');
    Route::put('/admin/kichthuoc/{idkt}', [admin\kichthuocController::class, 'update'])->name('admin.kichthuoc.update');
    Route::get('/admin/kichthuoc/search', [admin\kichthuocController::class, 'search'])->name('admin.kichthuoc.search');

    Route::get('/admin/tintuc', [admin\tintucController::class, 'index'])->name('admin.tintuc');
    Route::post('/admin/tintuc/them', [admin\tintucController::class, 'store'])->name('admin.tintuc.store');
    Route::delete('/admin/tintuc/{idtt}', [admin\tintucController::class, 'destroy'])->name('admin.tintuc.destroy');
    Route::post('/admin/tintuc/{idtt}', [admin\tintucController::class, 'update'])->name('admin.tintuc.update');
    Route::put('/admin/tintuc/{idtt}', [admin\tintucController::class, 'update'])->name('admin.tintuc.update');
    Route::get('/admin/tintuc/search', [admin\tintucController::class, 'search'])->name('admin.tintuc.search');

    Route::get('/admin/magiamgia', [admin\magiamgiaController::class, 'index'])->name('admin.magiamgia');
    Route::post('/admin/magiamgia/them', [admin\magiamgiaController::class, 'store'])->name('admin.magiamgia.store');
    Route::delete('/admin/magiamgia/{idgg}', [admin\magiamgiaController::class, 'destroy'])->name('admin.magiamgia.destroy');
    Route::post('/admin/magiamgia/{idgg}', [admin\magiamgiaController::class, 'update'])->name('admin.magiamgia.update');
    Route::put('/admin/magiamgia/{idgg}', [admin\magiamgiaController::class, 'update'])->name('admin.magiamgia.update');
    Route::get('/admin/magiamgia/search', [admin\magiamgiaController::class, 'search'])->name('admin.magiamgia.search');


    Route::get('/admin/phuongthucthanhtoan', [admin\phuongthucthanhtoanController::class, 'index'])->name('admin.phuongthucthanhtoan');
    Route::post('/admin/phuongthucthanhtoan/them', [admin\phuongthucthanhtoanController::class, 'store'])->name('admin.phuongthucthanhtoan.store');
    Route::delete('/admin/phuongthucthanhtoan/{idpttt}', [admin\phuongthucthanhtoanController::class, 'destroy'])->name('admin.phuongthucthanhtoan.destroy');
    Route::post('/admin/phuongthucthanhtoan/{idpttt}', [admin\phuongthucthanhtoanController::class, 'update'])->name('admin.phuongthucthanhtoan.update');
    Route::put('/admin/phuongthucthanhtoan/{idpttt}', [admin\phuongthucthanhtoanController::class, 'update'])->name('admin.phuongthucthanhtoan.update');
    Route::get('/admin/phuongthucthanhtoan/search', [admin\phuongthucthanhtoanController::class, 'search'])->name('admin.phuongthucthanhtoan.search');


    Route::get('/admin/phuongthucgiaohang', [admin\phuongthucgiaohangController::class, 'index'])->name('admin.phuongthucgiaohang');
    Route::post('/admin/phuongthucgiaohang/them', [admin\phuongthucgiaohangController::class, 'store'])->name('admin.phuongthucgiaohang.store');
    Route::delete('/admin/phuongthucgiaohang/{idptgh}', [admin\phuongthucgiaohangController::class, 'destroy'])->name('admin.phuongthucgiaohang.destroy');
    Route::post('/admin/phuongthucgiaohang/{idptgh}', [admin\phuongthucgiaohangController::class, 'update'])->name('admin.phuongthucgiaohang.update');
    Route::put('/admin/phuongthucgiaohang/{idptgh}', [admin\phuongthucgiaohangController::class, 'update'])->name('admin.phuongthucgiaohang.update');
    Route::get('/admin/phuongthucgiaohang/search', [admin\phuongthucgiaohangController::class, 'search'])->name('admin.phuongthucgiaohang.search');



    Route::get('/admin/thuonghieu', [admin\thuonghieuController::class, 'index'])->name('admin.thuonghieu');
    Route::post('/admin/thuonghieu/them', [admin\thuonghieuController::class, 'store'])->name('admin.thuonghieu.store');
    Route::delete('/admin/thuonghieu/{idth}', [admin\thuonghieuController::class, 'destroy'])->name('admin.thuonghieu.destroy');
    Route::post('/admin/thuonghieu/{idth}', [admin\thuonghieuController::class, 'update'])->name('admin.thuonghieu.update');
    Route::put('/admin/thuonghieu/{idth}', [admin\thuonghieuController::class, 'update'])->name('admin.thuonghieu.update');
    Route::get('/admin/thuonghieu/search', [admin\thuonghieuController::class, 'search'])->name('admin.thuonghieu.search');



    Route::get('/admin/nhanvien', [admin\nhanvienController::class, 'index'])->name('admin.nhanvien');
    Route::post('/admin/nhanvien/them', [admin\nhanvienController::class, 'store'])->name('admin.nhanvien.store');
    Route::delete('/admin/nhanvien/{idnv}', [admin\nhanvienController::class, 'destroy'])->name('admin.nhanvien.destroy');
    Route::post('/admin/nhanvien/{idnv}', [admin\nhanvienController::class, 'update'])->name('admin.nhanvien.update');
    Route::put('/admin/nhanvien/{idnv}', [admin\nhanvienController::class, 'update'])->name('admin.nhanvien.update');
    Route::get('/admin/nhanvien/search', [admin\nhanvienController::class, 'search'])->name('admin.nhanvien.search');

    Route::post('/admin/nhanvien/updatepassword/{idnv}', [admin\nhanvienController::class, 'updatePassword'])->name('admin.nhanvien.updatepassword');

    Route::get('/admin/thongke', [admin\thongkeController::class, 'index'])->name('admin.thongke');

    Route::post('/admin/xuatexcel', [admin\thongkeController::class, 'xuatexcel'])->name('admin.xuatexcel');

    Route::get('/admin/showviewthang', [admin\thongkeController::class, 'showViewThang'])->name('admin.showViewThang');


    Route::get('/admin/chitietsanpham/{id}', [admin\chitietsanphamController::class, 'show'])->name('admin.chitietsanpham');
    Route::post('/admin/chitietsanpham/them', [admin\chitietsanphamController::class, 'store'])->name('admin.chitietsanpham.store');

    Route::get('/admin/chitietsanpham1/{id}', [admin\chitietsanpham1Controller::class, 'index'])->name('admin.chitietsanpham1');
    Route::post('/admin/chitietsanpham1/them', [admin\chitietsanpham1Controller::class, 'store'])->name('admin.chitietsanpham1.store');
    Route::delete('/admin/chitietsanpham1/{id}', [admin\chitietsanpham1Controller::class, 'destroy'])->name('admin.chitietsanpham1.destroy');
    Route::post('/admin/chitietsanpham1/{id}', [admin\chitietsanpham1Controller::class, 'update'])->name('admin.chitietsanpham1.update');
    Route::put('/admin/chitietsanpham1/{id}', [admin\chitietsanpham1Controller::class, 'update'])->name('admin.chitietsanpham1.update');

    Route::get('/admin/trangthaidonhang', [admin\trangthaidonhangController::class, 'index'])->name('admin.trangthaidonhang');
    Route::post('/admin/trangthaidonhang/them', [admin\trangthaidonhangController::class, 'store'])->name('admin.trangthaidonhang.store');
    Route::delete('/admin/trangthaidonhang/{idttdh}', [admin\trangthaidonhangController::class, 'destroy'])->name('admin.trangthaidonhang.destroy');
    Route::post('/admin/trangthaidonhang/{idttdh}', [admin\trangthaidonhangController::class, 'update'])->name('admin.trangthaidonhang.update');
    Route::put('/admin/trangthaidonhang/{idttdh}', [admin\trangthaidonhangController::class, 'update'])->name('admin.trangthaidonhang.update');
    Route::get('/admin/trangthaidonhang/search', [admin\trangthaidonhangController::class, 'search'])->name('admin.trangthaidonhang.search');


    Route::get('/admin/donvivanchuyen', [admin\donvivanchuyenController::class, 'index'])->name('admin.donvivanchuyen');
    Route::post('/admin/donvivanchuyen/them', [admin\donvivanchuyenController::class, 'store'])->name('admin.donvivanchuyen.store');
    Route::delete('/admin/donvivanchuyen/{iddvvc}', [admin\donvivanchuyenController::class, 'destroy'])->name('admin.donvivanchuyen.destroy');
    Route::post('/admin/donvivanchuyen/{iddvvc}', [admin\donvivanchuyenController::class, 'update'])->name('admin.donvivanchuyen.update');
    Route::put('/admin/donvivanchuyen/{iddvvc}', [admin\donvivanchuyenController::class, 'update'])->name('admin.donvivanchuyen.update');
    Route::get('/admin/donvivanchuyen/search', [admin\donvivanchuyenController::class, 'search'])->name('admin.donvivanchuyen.search');


    Route::get('/admin/hoadon', [admin\hoadonController::class, 'index'])->name('admin.hoadon');
    Route::post('/admin/hoadon/them', [admin\hoadonController::class, 'store'])->name('admin.hoadon.store');
    Route::delete('/admin/hoadon/{idhd}', [admin\hoadonController::class, 'destroy'])->name('admin.hoadon.destroy');
    Route::post('/admin/hoadon/{idhd}', [admin\hoadonController::class, 'update'])->name('admin.hoadon.update');
    Route::put('/admin/hoadon/{idhd}', [admin\hoadonController::class, 'update'])->name('admin.hoadon.update');
    Route::get('/admin/hoadon/search', [admin\hoadonController::class, 'search'])->name('admin.hoadon.search');
    Route::get('/admin/hoadon/capnhattrangthai/{iddh}', [admin\hoadonController::class, 'capnhatTrangThai'])->name('admin.capnhatTrangThai');
    Route::get('/admin/hoadon/capnhattrangthai1/{iddh}', [admin\hoadonController::class, 'capnhatTrangThai1'])->name('admin.capnhatTrangThai1');


    Route::get('/admin/danhmucsanpham', [admin\danhmucsanphamController::class, 'index'])->name('admin.danhmucsanpham');
    Route::post('admin/danhmucsanpham/them', [admin\danhmucsanphamController::class, 'store'])->name('admin.danhmucsanpham.store');
    Route::delete('/admin/danhmucsanpham/{iddm}', [admin\danhmucsanphamController::class, 'destroy'])->name('admin.danhmucsanpham.destroy');
    Route::post('/admin/danhmucsanpham/{iddm}', [admin\danhmucsanphamController::class, 'update'])->name('admin.danhmucsanpham.update');
    Route::put('/admin/danhmucsanpham/{iddm}', [admin\danhmucsanphamController::class, 'update'])->name('admin.danhmucsanpham.update');
    Route::get('/admin/danhmucsanpham/search', [admin\danhmucsanphamController::class, 'search'])->name('admin.danhmucsanpham.search');



    Route::post('/admin/hinhanh/main-image/{idsp}', [admin\hinhanhController::class, 'store'])->name('admin.hinhanh.store');
    Route::post('/admin/hinhanh/{idh}', [admin\hinhanhController::class, 'update'])->name('admin.hinhanh.update');
    Route::put('/admin/hinhanh/{idh}', [admin\hinhanhController::class, 'update'])->name('admin.hinhanh.update');
    Route::delete('/admin/hinhanh/{idh}', [admin\hinhanhController::class, 'destroy'])->name('admin.hinhanh.destroy');



    Route::resource('hinhanhs1', admin\hinhanh1Controller::class);
    Route::post('hinhanhs1/{idsp}', [admin\hinhanh1Controller::class, 'store'])->name('hinhanhs1.store');


    Route::get('/admin/lapdonhang', [admin\lapdonhangController::class, 'show'])->name('admin.lapdonhang');
    Route::post('/admin/lapdonhang/add', [admin\lapdonhangController::class, 'store'])->name('admin.lapdonhang.store');
    Route::put('/admin/lapdonhang/update/{id}', [admin\lapdonhangController::class, 'update'])->name('admin.lapdonhang.update');

    Route::get('/admin/themspdonhang/', [admin\themspdonhangController::class, 'show'])->name('admin.themspdonhang');
    Route::post('/admin/themspdonhang/add', [admin\themspdonhangController::class, 'store'])->name('admin.themspdonhang.store');
    Route::delete('/admin/lapdonhang/xoaspdonhang/{index}', [admin\lapdonhangController::class, 'destroy'])->name('admin.lapdonhang.destroy');


    Route::delete('admin/hoadon/{id}', [admin\hoadonController::class, 'destroy'])->name('admin.hoadon.destroy');

    Route::get('/admin/hoadon/update-order-status/{iddh}', [admin\hoadonController::class, 'updateOrderStatus'])->name('admin.update-order-status');



    Route::get('/admin/chitietdonhang/{id}', [admin\chitiethoadonController::class, 'index'])->name('admin.chitiethoadon');

    Route::get('/admin/chitietdonhang/{id}/hoadon', [admin\chitiethoadonController::class, 'xuathoadon'])->name('admin.chitiethoadon.hoadon');

    Route::post('/admin/chitietdonhang/lapphieugiaohanng', [admin\chitiethoadonController::class, 'lapphieugiaohanng'])->name('admin.chitiethoadon.lapphieugiaohanng');


    Route::post('/admin/dangxuat', [admin\loginController::class, 'dangxuat'])->name('admin.dangxuat');

    Route::get('/admin/khohang', [admin\khohangController::class, 'index'])->name('admin.khohang');

   
    Route::post('/admin/xuatexcel', [admin\thongkeController::class, 'exportExcel'])->name('admin.xuatexcel');

});
