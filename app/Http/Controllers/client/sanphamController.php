<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\ChiTietGioHang;
use App\Models\ChiTietSanPham;
use App\Models\DanhMucSanPham;
use App\Models\KichThuoc;
use Illuminate\Http\Request;
use App\Models\LoaiSanPham;
use App\Models\LoaiTinTuc;
use App\Models\Mau;
use App\Models\SanPham;
use App\Models\ThuongHieu;

class sanphamController extends Controller
{

    // Phương thức để lấy sản phẩm quần áo bé trai
    public function sanphambetrai(Request $request)
    {
        $loaisanpham = LoaiSanPham::all();
        // $perPage = $request->input('per_page', 6);

        $loaisanphamgt = LoaiSanPham::whereHas('danhmucsanpham', function ($query) {
            $query->where('gioitinh', 0); // Giới tính 0 cho bé trai
        })->get(); // Lọc các sản phẩm bé trai theo danh mục

        $loaitintuc = LoaiTinTuc::all();
        $kichthuoc = KichThuoc::all();
        $thuonghieu = ThuongHieu::all();
        $mau = Mau::all();
        $title = 'Quần áo bé trai';

        // Lấy danh mục sản phẩm
        $danhmucsanpham = DanhMucSanPham::all();  // Thêm dòng này để lấy danh mục sản phẩm

        // Lấy số lượng sản phẩm hiển thị từ yêu cầu, mặc định là 6

        // Lấy sản phẩm quần áo bé trai với phân trang
        $sanpham = SanPham::whereHas('loaiSanPham.danhmucsanpham', function ($query) {
            $query->where('gioitinh', 0); // Giới tính 0 là quần áo bé trai
        })->paginate(6);

        $hinhbanner = asset('client/img/banner/bannerthoitrangbetrai.png');
        $danhMuc = 'Quần áo bé trai'; // Truyền tên danh mục vào view

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
            return view('client.sanpham', compact(
                'title',
                'loaisanpham',
                'loaisanphamgt',
                'loaitintuc',
                'sanpham',
                'mau',
                'kichthuoc',
                'thuonghieu',
                'danhmucsanpham', // Truyền biến này vào view
                'danhMuc',
                'hinhbanner',
                'chitietgiohang',
                'tongTien',
                'soLuongSanPham'
            ));
        } else {

            // Nếu người dùng chưa đăng nhập, giỏ hàng sẽ trống và tổng tiền bằng 0
            

            $tongTien = 0;
            $soLuongSanPham = 0;

            $chitietgiohang = session()->get('giohang', []);

            foreach ($chitietgiohang as $ctgh) {
                // Kiểm tra nếu sanpham là đối tượng ChiTietSanPham
                if (isset($ctgh['sanpham']) && $ctgh['sanpham'] instanceof ChiTietSanPham) {
                    
                    $ctsp = $ctgh['sanpham']; // Lấy đối tượng ChiTietSanPham từ sanpham
                    $giaSanPham = $ctsp->sanpham->gia;

                    // Kiểm tra giảm giá nếu có
                    if ($ctsp->sanpham->giamgia && $ctsp->sanpham->giamgia->phantram > 0) {
                        $giaSanPham -= ($giaSanPham * $ctsp->sanpham->giamgia->phantram) / 100;
                    }

                    // Tính tổng tiền và số lượng sản phẩm
                    $tongTien += $giaSanPham * $ctgh['soluong'];
                    $soLuongSanPham += $ctgh['soluong'];
                }
            }





            // Trả về view `giohang1` với các giá trị đã tính toán
            return view('client.sanpham', compact(
                'title',
                'loaisanpham',
                'loaisanphamgt',
                'loaitintuc',
                'sanpham',
                'mau',
                'kichthuoc',
                'thuonghieu',
                'danhmucsanpham', // Truyền biến này vào view
                'danhMuc',
                'hinhbanner',
                'chitietgiohang',
                'tongTien',
                'soLuongSanPham'
            ));
        }
    }
    public function sanphambegai(Request $request)
    {
        $loaisanpham = LoaiSanPham::all();
        $loaisanphamgt = LoaiSanPham::whereHas('danhmucsanpham', function ($query) {
            $query->where('gioitinh', 1);
        })->get(); // Lọc các sản phẩm bé trai theo danh mục

        $loaitintuc = LoaiTinTuc::all();
        $kichthuoc = KichThuoc::all();
        $thuonghieu = ThuongHieu::all();
        $mau = Mau::all();
        $title = 'Quần áo bé gái';

        // Lấy danh mục sản phẩm
        $danhmucsanpham = DanhMucSanPham::all();  // Thêm dòng này để lấy danh mục sản phẩm

        // Lấy số lượng sản phẩm hiển thị từ yêu cầu, mặc định là 6
        $perPage = $request->input('per_page', 6);

        // Lấy sản phẩm quần áo bé trai với phân trang
        $sanpham = SanPham::whereHas('loaiSanPham.danhmucsanpham', function ($query) {
            $query->where('gioitinh', 1);
        })->paginate($perPage);

        $hinhbanner = asset('client/img/banner/bannerthoitrangbegai.png');
        $danhMuc = 'Quần áo bé gái'; // Truyền tên danh mục vào view

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
            return view('client.sanpham', compact(
                'title',
                'loaisanpham',
                'loaisanphamgt',
                'loaitintuc',
                'sanpham',
                'mau',
                'kichthuoc',
                'thuonghieu',
                'danhmucsanpham', // Truyền biến này vào view
                'danhMuc',
                'hinhbanner',
                'chitietgiohang',
                'tongTien',
                'soLuongSanPham'
            ));
        } else {
            // Lấy chi tiết giỏ hàng từ session
            // Nếu người dùng chưa đăng nhập, giỏ hàng sẽ trống và tổng tiền bằng 0
            $tongTien = 0;
            $soLuongSanPham = 0;
            $chitietgiohang = session()->get('giohang', []);

            foreach ($chitietgiohang as $ctgh) {
                // Kiểm tra nếu sanpham là đối tượng ChiTietSanPham
                if (isset($ctgh['sanpham']) && $ctgh['sanpham'] instanceof ChiTietSanPham) {

                    $ctsp = $ctgh['sanpham']; // Lấy đối tượng ChiTietSanPham từ sanpham
                    $giaSanPham = $ctsp->sanpham->gia;

                    // Kiểm tra giảm giá nếu có
                    if ($ctsp->sanpham->giamgia && $ctsp->sanpham->giamgia->phantram > 0) {
                        $giaSanPham -= ($giaSanPham * $ctsp->sanpham->giamgia->phantram) / 100;
                    }

                    // Tính tổng tiền và số lượng sản phẩm
                    $tongTien += $giaSanPham * $ctgh['soluong'];
                    $soLuongSanPham += $ctgh['soluong'];
                }
            }
            return view('client.sanpham', compact(
                'title',
                'loaisanpham',
                'loaisanphamgt',
                'loaitintuc',
                'sanpham',
                'mau',
                'kichthuoc',
                'thuonghieu',
                'danhmucsanpham', // Truyền biến này vào view
                'danhMuc',
                'hinhbanner',
                'chitietgiohang',
                'tongTien',
                'soLuongSanPham'
            ));
        }
    }
    public function loaisanphambetrai($ten, Request $request)
    {
        // Lấy tất cả loại sản phẩm để hiển thị trên menu
        $loaitintuc = LoaiTinTuc::all();
        $kichthuoc = KichThuoc::all();
        $thuonghieu = ThuongHieu::all();
        $mau = Mau::all();

        // Lấy tất cả danh mục sản phẩm
        $danhmucsanpham = DanhMucSanPham::all();

        // $id = explode('-', $slug);
        // $id = end($id);
        $danhmuc = DanhMucSanPham::where('ten', 'like', '%' . str_replace('-', ' ', $ten) . '%')->first();

        // Lấy danh mục sản phẩm theo id
        // $danhmuc = DanhMucSanPham::find($id); // Sử dụng find() thay vì where() để tìm nhanh theo ID
        // Kiểm tra nếu tìm thấy danh mục sản phẩm
        if (!$danhmuc) {
            // Trả về 404 nếu không tìm thấy danh mục
            abort(404);
        }

        // Lấy các loại sản phẩm thuộc danh mục này
        $loaisanpham = LoaiSanPham::where('iddm', $danhmuc->iddm)->get();

        // Các mã còn lại để lấy và hiển thị sản phẩm
        $gioitinh = $request->input('gioitinh', 0); // Mặc định là "0" (bé trai)
        $perPage = $request->input('per_page', 6);

        $sanpham = SanPham::whereHas('loaiSanPham.danhmucsanpham', function ($query) use ($danhmuc, $gioitinh) {
            $query->where('iddm', $danhmuc->iddm)
                ->where('gioitinh', $gioitinh);
        })->paginate($perPage);


        // Xác định danh mục hiển thị
        $danhMuc = $danhmuc->ten;
        $hinhbanner = asset('client/img/banner/bannerthoitrangbetrai.png');
        $title = $danhMuc;

        // Kiểm tra giỏ hàng nếu người dùng đã đăng nhập
        if (auth()->check()) {
            $idkh = auth()->user()->idkh;

            // Lấy chi tiết giỏ hàng của người dùng
            $chitietgiohang = ChiTietGioHang::with('chitietsanpham.sanpham')
                ->whereHas('giohang', function ($query) use ($idkh) {
                    $query->where('idkh', $idkh);
                })
                ->get();

            // Tính tổng tiền và số lượng
            $tongTien = 0;
            $soLuongSanPham = 0;

            foreach ($chitietgiohang as $ctgh) {
                foreach ($ctgh->chitietsanpham as $ctsp) {
                    $giaSanPham = $ctsp->sanpham->gia;

                    // Kiểm tra giảm giá
                    if ($ctsp->sanpham->giamgia && $ctsp->sanpham->giamgia->phantram > 0) {
                        $giaSanPham -= ($giaSanPham * $ctsp->sanpham->giamgia->phantram) / 100;
                    }

                    // Cộng tổng tiền và số lượng
                    $tongTien += $giaSanPham * $ctgh->soluong;
                    $soLuongSanPham += $ctgh->soluong;
                }
            }
            return view('client.sanphamtheoloai', compact(
                'title',
                'loaisanpham', // Truyền loaiSanPham cho view
                'loaitintuc',
                'sanpham',
                'mau',
                'kichthuoc',
                'thuonghieu',
                'danhMuc',
                'hinhbanner',
                'chitietgiohang',
                'tongTien',
                'soLuongSanPham',
                'danhmucsanpham'
            ));
        } else {

            $tongTien = 0;
            $soLuongSanPham = 0;
            $chitietgiohang = session()->get('giohang', []);

            foreach ($chitietgiohang as $ctgh) {
                // Kiểm tra nếu sanpham là đối tượng ChiTietSanPham
                if (isset($ctgh['sanpham']) && $ctgh['sanpham'] instanceof ChiTietSanPham) {

                    $ctsp = $ctgh['sanpham']; // Lấy đối tượng ChiTietSanPham từ sanpham
                    $giaSanPham = $ctsp->sanpham->gia;

                    // Kiểm tra giảm giá nếu có
                    if ($ctsp->sanpham->giamgia && $ctsp->sanpham->giamgia->phantram > 0) {
                        $giaSanPham -= ($giaSanPham * $ctsp->sanpham->giamgia->phantram) / 100;
                    }

                    // Tính tổng tiền và số lượng sản phẩm
                    $tongTien += $giaSanPham * $ctgh['soluong'];
                    $soLuongSanPham += $ctgh['soluong'];
                }
            }
            return view('client.sanphamtheoloai', compact(
                'title',
                'loaisanpham', // Truyền loaiSanPham cho view
                'loaitintuc',
                'sanpham',
                'mau',
                'kichthuoc',
                'thuonghieu',
                'danhMuc',
                'hinhbanner',
                'chitietgiohang',
                'tongTien',
                'soLuongSanPham',
                'danhmucsanpham'
            ));
        }

        // Truyền tất cả biến cần thiết vào view

    }
    public function loaisanphambegai($ten, Request $request)
    {
        // Lấy tất cả loại sản phẩm để hiển thị trên menu
        $loaitintuc = LoaiTinTuc::all();
        $kichthuoc = KichThuoc::all();
        $thuonghieu = ThuongHieu::all();
        $mau = Mau::all();

        // Lấy tất cả danh mục sản phẩm
        $danhmucsanpham = DanhMucSanPham::all();

        // $id = explode('-', $slug);
        // $id = end($id);
        $danhmuc = DanhMucSanPham::where('ten', 'like', '%' . str_replace('-', ' ', $ten) . '%')->first();

        // Lấy danh mục sản phẩm theo id
        // $danhmuc = DanhMucSanPham::find($id); // Sử dụng find() thay vì where() để tìm nhanh theo ID
        // Kiểm tra nếu tìm thấy danh mục sản phẩm
        if (!$danhmuc) {
            // Trả về 404 nếu không tìm thấy danh mục
            abort(404);
        }

        // Lấy các loại sản phẩm thuộc danh mục này
        $loaisanpham = LoaiSanPham::where('iddm', $danhmuc->iddm)->get();

        // Các mã còn lại để lấy và hiển thị sản phẩm
        $gioitinh = $request->input('gioitinh', 1); // Mặc định là "0" (bé trai)
        $perPage = $request->input('per_page', 6);

        $sanpham = SanPham::whereHas('loaiSanPham.danhmucsanpham', function ($query) use ($danhmuc, $gioitinh) {
            $query->where('iddm', $danhmuc->iddm)
                ->where('gioitinh', $gioitinh);
        })->paginate($perPage);


        // Xác định danh mục hiển thị
        $danhMuc = $danhmuc->ten;
        $hinhbanner = asset('client/img/banner/bannerthoitrangbegai.png');
        $title = $danhMuc;

        // Kiểm tra giỏ hàng nếu người dùng đã đăng nhập
        if (auth()->check()) {
            $idkh = auth()->user()->idkh;

            // Lấy chi tiết giỏ hàng của người dùng
            $chitietgiohang = ChiTietGioHang::with('chitietsanpham.sanpham')
                ->whereHas('giohang', function ($query) use ($idkh) {
                    $query->where('idkh', $idkh);
                })
                ->get();

            // Tính tổng tiền và số lượng
            $tongTien = 0;
            $soLuongSanPham = 0;

            foreach ($chitietgiohang as $ctgh) {
                foreach ($ctgh->chitietsanpham as $ctsp) {
                    $giaSanPham = $ctsp->sanpham->gia;

                    // Kiểm tra giảm giá
                    if ($ctsp->sanpham->giamgia && $ctsp->sanpham->giamgia->phantram > 0) {
                        $giaSanPham -= ($giaSanPham * $ctsp->sanpham->giamgia->phantram) / 100;
                    }

                    // Cộng tổng tiền và số lượng
                    $tongTien += $giaSanPham * $ctgh->soluong;
                    $soLuongSanPham += $ctgh->soluong;
                }
            }
            return view('client.sanphamtheoloai', compact(
                'title',
                'loaisanpham', // Truyền loaiSanPham cho view
                'loaitintuc',
                'sanpham',
                'mau',
                'kichthuoc',
                'thuonghieu',
                'danhMuc',
                'hinhbanner',
                'chitietgiohang',
                'tongTien',
                'soLuongSanPham',
                'danhmucsanpham'
            ));
        } else {
            // Lấy chi tiết giỏ hàng từ session
            // Nếu người dùng chưa đăng nhập, giỏ hàng sẽ trống và tổng tiền bằng 0
            $tongTien = 0;
            $soLuongSanPham = 0;
            $chitietgiohang = session()->get('giohang', []);

            foreach ($chitietgiohang as $ctgh) {
                // Kiểm tra nếu sanpham là đối tượng ChiTietSanPham
                if (isset($ctgh['sanpham']) && $ctgh['sanpham'] instanceof ChiTietSanPham) {

                    $ctsp = $ctgh['sanpham']; // Lấy đối tượng ChiTietSanPham từ sanpham
                    $giaSanPham = $ctsp->sanpham->gia;

                    // Kiểm tra giảm giá nếu có
                    if ($ctsp->sanpham->giamgia && $ctsp->sanpham->giamgia->phantram > 0) {
                        $giaSanPham -= ($giaSanPham * $ctsp->sanpham->giamgia->phantram) / 100;
                    }

                    // Tính tổng tiền và số lượng sản phẩm
                    $tongTien += $giaSanPham * $ctgh['soluong'];
                    $soLuongSanPham += $ctgh['soluong'];
                }
            }
            return view('client.sanphamtheoloai', compact(
                'title',
                'loaisanpham', // Truyền loaiSanPham cho view
                'loaitintuc',
                'sanpham',
                'mau',
                'kichthuoc',
                'thuonghieu',
                'danhMuc',
                'hinhbanner',
                'chitietgiohang',
                'tongTien',
                'soLuongSanPham',
                'danhmucsanpham'
            ));
        }

        // Truyền tất cả biến cần thiết vào view

    }



    public function sanphamnoibat(Request $request)
    {
        $danhmucsanpham = DanhMucSanPham::all();
        $loaitintuc = LoaiTinTuc::all();
        $kichthuoc = KichThuoc::all();
        $thuonghieu = ThuongHieu::all();
        $mau = Mau::all();
        $title = 'Sản phẩm nổi bật';

        // Lấy số lượng sản phẩm hiển thị từ yêu cầu, mặc định là 5
        $perPage = $request->input('per_page', 6);

        // Lấy sản phẩm quần áo bé trai với phân trang
        $sanpham = SanPham::where('noibat', 1)->paginate($perPage); // Lấy sản phẩm có trường 'moi' là 1
        $loaisanphamgt = LoaiSanPham::distinct()->get();

        $hinhbanner = asset('client/img/banner/bannernoibat.jpg');
        $danhMuc = 'Sản phẩm nổi bật'; // Truyền tên danh mục vào view
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
            return view('client.sanpham1', compact(
                'title',
                'danhmucsanpham',
                'loaisanphamgt',
                'loaitintuc',
                'sanpham',
                'mau',
                'kichthuoc',
                'danhMuc',
                'hinhbanner',
                'thuonghieu',
                'chitietgiohang',
                'tongTien',
                'soLuongSanPham'
            ));
        } else {
            // Lấy chi tiết giỏ hàng từ session
            $tongTien = 0;
            $soLuongSanPham = 0;
            $chitietgiohang = session()->get('giohang', []);

            foreach ($chitietgiohang as $ctgh) {
                // Kiểm tra nếu sanpham là đối tượng ChiTietSanPham
                if (isset($ctgh['sanpham']) && $ctgh['sanpham'] instanceof ChiTietSanPham) {

                    $ctsp = $ctgh['sanpham']; // Lấy đối tượng ChiTietSanPham từ sanpham
                    $giaSanPham = $ctsp->sanpham->gia;

                    // Kiểm tra giảm giá nếu có
                    if ($ctsp->sanpham->giamgia && $ctsp->sanpham->giamgia->phantram > 0) {
                        $giaSanPham -= ($giaSanPham * $ctsp->sanpham->giamgia->phantram) / 100;
                    }

                    // Tính tổng tiền và số lượng sản phẩm
                    $tongTien += $giaSanPham * $ctgh['soluong'];
                    $soLuongSanPham += $ctgh['soluong'];
                }
            }
            return view('client.sanpham1', compact(
                'title',
                'danhmucsanpham',
                'loaisanphamgt',
                'loaitintuc',
                'sanpham',
                'mau',
                'kichthuoc',
                'danhMuc',
                'hinhbanner',
                'thuonghieu',
                'chitietgiohang',
                'tongTien',
                'soLuongSanPham'
            ));
        }
    }
    public function sanphammoi(Request $request)
    {
        // Lấy tất cả loại sản phẩm
        $danhmucsanpham = DanhMucSanPham::all();
        $loaitintuc = LoaiTinTuc::all();
        $kichthuoc = KichThuoc::all();
        $thuonghieu = ThuongHieu::all();
        $mau = Mau::all();
        $title = 'Sản phẩm mới';

        // Lấy số lượng sản phẩm hiển thị từ yêu cầu, mặc định là 6
        $perPage = $request->input('per_page', 6);

        // Lấy sản phẩm mới (trường 'moi' bằng 1) với phân trang
        $sanpham = SanPham::where('moi', 1)->paginate($perPage); // Lấy sản phẩm có trường 'moi' là 1
        $loaisanphamgt = LoaiSanPham::all();

        $hinhbanner = asset('client/img/banner/bannermoi.jpg');
        $danhMuc = 'Sản phẩm mới'; // Truyền tên danh mục vào view
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
            return view('client.sanpham1', compact(
                'title',
                'danhmucsanpham',
                'loaitintuc',
                'sanpham',
                'mau',
                'kichthuoc',
                'thuonghieu',
                'loaisanphamgt',
                'hinhbanner',
                'chitietgiohang',
                'tongTien',
                'soLuongSanPham'
            ))
                ->with('danhMuc', $danhMuc); // Truyền tên danh mục vào view
        } else {
            // Lấy chi tiết giỏ hàng từ session
            // Nếu người dùng chưa đăng nhập, giỏ hàng sẽ trống và tổng tiền bằng 0
            $tongTien = 0;
            $soLuongSanPham = 0;
            $chitietgiohang = session()->get('giohang', []);

            foreach ($chitietgiohang as $ctgh) {
                // Kiểm tra nếu sanpham là đối tượng ChiTietSanPham
                if (isset($ctgh['sanpham']) && $ctgh['sanpham'] instanceof ChiTietSanPham) {

                    $ctsp = $ctgh['sanpham']; // Lấy đối tượng ChiTietSanPham từ sanpham
                    $giaSanPham = $ctsp->sanpham->gia;

                    // Kiểm tra giảm giá nếu có
                    if ($ctsp->sanpham->giamgia && $ctsp->sanpham->giamgia->phantram > 0) {
                        $giaSanPham -= ($giaSanPham * $ctsp->sanpham->giamgia->phantram) / 100;
                    }

                    // Tính tổng tiền và số lượng sản phẩm
                    $tongTien += $giaSanPham * $ctgh['soluong'];
                    $soLuongSanPham += $ctgh['soluong'];
                }
            }
            // Truyền dữ liệu vào view
            return view('client.sanpham1', compact(
                'title',
                'danhmucsanpham',
                'loaitintuc',
                'sanpham',
                'mau',
                'kichthuoc',
                'thuonghieu',
                'loaisanphamgt',
                'hinhbanner',
                'chitietgiohang',
                'tongTien',
                'soLuongSanPham'
            ))
                ->with('danhMuc', $danhMuc); // Truyền tên danh mục vào view
        }
    }
}
