<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\ChiTietGioHang;
use App\Models\DanhMucSanPham;
use Illuminate\Http\Request;
use App\Models\LoaiSanPham;
use App\Models\LoaiTinTuc;
use App\Models\TinTuc;
use Illuminate\Support\Str;

class tintucController extends Controller
{
    public function index()
    {
        $danhmucsanpham = DanhMucSanPham::all();
        $loaitintuc = LoaiTinTuc::all();
        $tintuc = TinTuc::paginate(6); // Phân trang, 6 tin mỗi trang
        $danhmuc = 'tin tức';
        $title = 'Tin tức';
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
            return view('client.tintuc', compact('danhmucsanpham', 'loaitintuc', 'tintuc', 'danhmuc', 'title', 'chitietgiohang', 'tongTien', 'soLuongSanPham'));
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
            return view('client.tintuc', compact('danhmucsanpham', 'loaitintuc', 'tintuc', 'chitietgiohang', 'tongTien', 'danhmuc', 'soLuongSanPham', 'title',));
        }
    }

    public function showByType($ten, Request $request)
    {
        // Lấy tất cả danh mục sản phẩm và loại tin tức để hiển thị
        $danhmucsanpham = DanhMucSanPham::all();
        $loaitintuc = LoaiTinTuc::all(); // Lấy danh sách tất cả loại tin tức

        // Tìm loại tin tức theo tên (đảm bảo rằng tên loại tin tức đã được slug hóa)
        $loaiTinTuc = LoaiTinTuc::where('ten', 'like', '%' . str_replace('-', ' ', $ten) . '%')->first();

        if (!$loaiTinTuc) {
            // Nếu không tìm thấy loại tin tức, trả về trang 404
            abort(404, 'Không tìm thấy loại tin tức.');
        }

        // Lấy tin tức liên quan đến loại tin tức vừa tìm được và sử dụng phân trang
        $perPage = $request->input('per_page', 6); // Số lượng sản phẩm trên mỗi trang, mặc định là 6
        $tintuc = TinTuc::where('idltt', $loaiTinTuc->idltt)->paginate($perPage);

        // Lấy danh mục và tiêu đề
        $danhmuc = $loaiTinTuc->ten;
        $title = $loaiTinTuc->ten;

        // Xử lý giỏ hàng nếu người dùng đã đăng nhập
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
            return view('client.tintuc', compact(
                'danhmucsanpham',
                'loaitintuc',
                'tintuc',
                'danhmuc',
                'title',
                'chitietgiohang',
                'tongTien',
                'soLuongSanPham'
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
            return view('client.tintuc', compact('danhmucsanpham', 'loaitintuc', 'tintuc', 'chitietgiohang', 'tongTien', 'danhmuc', 'soLuongSanPham', 'title',));
        }
    }


    public function show($ten, $tieude)
    {
        // Lấy tất cả loại sản phẩm và loại tin tức để hiển thị
        $danhmucsanpham = DanhMucSanPham::all();
        $loaitintuc = LoaiTinTuc::all();



        // Tìm loại tin tức theo tên
        $loaiTinTuc = LoaiTinTuc::where('ten', 'like', '%' . str_replace('-', ' ', $ten) . '%')->first();

        if (!$loaiTinTuc) {
            abort(404, "Không tìm thấy loại tin tức với tên: $ten");
        }

        // Tìm tin tức theo tiêu đề đã chuyển thành slug và loại tin tức
        $tintuc = TinTuc::where('tieude', 'like', '%' . str_replace('-', ' ', $tieude) . '%')  // Dùng tiêu đề thực tế, không phải slug
            ->where('idltt', $loaiTinTuc->idltt) // Dùng id của loại tin tức
            ->first();

        if (!$tintuc) {
            abort(404, "Không tìm thấy tin tức với tiêu đề: $tieude");
        }

        // Lấy danh sách tin tức liên quan cùng loại
        $tinTucLienQuan = TinTuc::where('idltt', $tintuc->idltt)
            ->where('idtt', '!=', $tintuc->idtt)
            ->get();

        // Xử lý giỏ hàng và tổng tiền nếu người dùng đã đăng nhập
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
            return view('client.chitiettintuc', compact(
                'danhmucsanpham',
                'loaitintuc',
                'tintuc',
                'tinTucLienQuan',
                'chitietgiohang',
                'tongTien',
                'soLuongSanPham'
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
            return view('client.chitiettintuc', compact('danhmucsanpham', 'loaitintuc', 'tintuc','tinTucLienQuan', 'chitietgiohang', 'tongTien', 'soLuongSanPham'));
        }
    }
}
