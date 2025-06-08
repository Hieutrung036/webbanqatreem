<?php

namespace App\Http\Controllers\client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ChiTietGioHang;
use App\Models\ChiTietSanPham;
use App\Models\DanhGia;
use App\Models\DanhMucSanPham;
use App\Models\KichThuoc;
use App\Models\LoaiSanPham;
use App\Models\LoaiTinTuc;
use App\Models\PhuongThucGiaoHang;
use App\Models\SanPham;
use App\Models\ThuongHieu;
use Illuminate\Support\Facades\DB;

// Các class khác...

class chitietsanphamController extends Controller
{
    public function index($slug)
    {


        // Lấy các loại sản phẩm, loại tin tức, thương hiệu và phương thức giao hàng
        $danhmucsanpham = DanhMucSanPham::all();
        $loaitintuc = LoaiTinTuc::all();
        $thuonghieu = ThuongHieu::all();
        $phuongthucgiaohang = PhuongThucGiaoHang::all();
        $kichthuoc = KichThuoc::all();

        // Giải mã slug thành id
        $id = explode('-', $slug);
        $id = end($id);

        // Lấy sản phẩm theo ID, nếu không tìm thấy, trả về lỗi 404
        $sanpham = SanPham::find($id);
        if (!$sanpham) {
            abort(404); // Trả về trang 404 nếu sản phẩm không tồn tại
        }

        $productId = $sanpham->idsp; // Hoặc sử dụng $sanpham->id nếu id là key chính của sản phẩm

        // Lấy chi tiết sản phẩm liên quan (hình ảnh, màu sắc, kích thước)
        $chitietsanpham = ChiTietSanPham::where('idsp', $id)->with(['hinhanh', 'mau', 'kichthuoc'])->get();
        $mau = $chitietsanpham->pluck('mau')->unique('idm');
        $kichthuoc = $chitietsanpham->pluck('kichthuoc')->unique('idkt');

        // Đặt tên danh mục là tên sản phẩm
        $danhmuc = $sanpham->ten; // Lấy tên sản phẩm

        // Lấy sản phẩm liên quan
        $sanphamlienquan = SanPham::where('idlsp', $sanpham->idlsp)
            ->where('idsp', '!=', $id)
            ->take(100) // Giới hạn số sản phẩm hiển thị, có thể thay đổi
            ->get();

        // Lưu danh sách sản phẩm đã xem vào session
        $viewedProducts = session()->get('viewed_products', []);
        if (!in_array($id, $viewedProducts)) {
            $viewedProducts[] = $id;
            session()->put('viewed_products', $viewedProducts);
        }

        // Lấy thông tin các sản phẩm đã xem
        $sanphamdaxem = SanPham::whereIn('idsp', $viewedProducts)->get();

        $danhgia = DanhGia::with('phanhoi') // Nạp quan hệ phản hồi
            ->where('idctsp', $id) // idctsp là ID chi tiết sản phẩm
            ->join('khachhang', 'danhgia.idkh', '=', 'khachhang.idkh')
            ->select('danhgia.*', 'khachhang.ten as ten_khachhang') // Lấy tên khách hàng cùng với đánh giá
            ->get();


        // Nếu người dùng đã đăng nhập, lấy thông tin giỏ hàng
        if (auth()->check()) {
            $idkh = auth()->user()->idkh;

            // Lấy chi tiết giỏ hàng của người dùng
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
            return view('client.chitietsanpham', compact(
                'sanphamdaxem',
                'sanphamlienquan',
                'mau',
                'kichthuoc',
                'danhmucsanpham',
                'loaitintuc',
                'danhmuc',
                'sanpham',
                'chitietsanpham',
                'thuonghieu',
                'phuongthucgiaohang',
                'chitietgiohang',
                'tongTien',
                'soLuongSanPham',
                'productId',
                'danhgia' // Truyền dữ liệu đánh giá vào view

            ));
        }
        
        // Truyền dữ liệu vào view
        else {
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
                    if (
                        $ctsp->sanpham->giamgia && $ctsp->sanpham->giamgia->phantram > 0
                    ) {
                        $giaSanPham -= ($giaSanPham * $ctsp->sanpham->giamgia->phantram) / 100;
                    }

                    // Tính tổng tiền và số lượng sản phẩm
                    $tongTien += $giaSanPham * $ctgh['soluong'];
                    $soLuongSanPham += $ctgh['soluong'];
                }
            }
        }
        return view('client.chitietsanpham', compact(
            'sanphamdaxem',
            'sanphamlienquan',
            'mau',
            'kichthuoc',
            'danhmucsanpham',
            'loaitintuc',
            'danhmuc',
            'sanpham',
            'chitietsanpham',
            'thuonghieu',
            'phuongthucgiaohang',
            'chitietgiohang',
            'tongTien',
            'productId', // Đảm bảo rằng biến $productId được truyền

            'soLuongSanPham',
            'danhgia' // Truyền dữ liệu đánh giá vào view

        ));
    }

    public function checkStock(Request $request)
    {
        // Lấy ID sản phẩm, màu và kích thước từ yêu cầu
        $productId = $request->input('product_id');
        $colorId = $request->input('color');
        $sizeId = $request->input('size');

        // Lấy sản phẩm
        $sanpham = SanPham::findOrFail($productId);

        // Lấy chi tiết sản phẩm dựa trên màu và kích thước đã chọn
        $chitietsanpham = $sanpham->chitietsanpham()
            ->where('idm', $colorId)
            ->where('idkt', $sizeId)
            ->first();

        // Kiểm tra số lượng tồn kho của chi tiết sản phẩm
        $stock = $chitietsanpham ? $chitietsanpham->soluong : 0;

        return response()->json(['stock' => $stock]);
    }
    public function checkStock1(Request $request)
    {
        // Lấy ID chi tiết giỏ hàng (idctgh) và số lượng yêu cầu từ yêu cầu AJAX
        $idctgh = $request->input('idctgh');
        $newQuantity = $request->input('soluong');

        // Lấy chi tiết sản phẩm từ giỏ hàng
        $chitietsanpham = ChiTietGioHang::findOrFail($idctgh);

        // Kiểm tra số lượng tồn kho của chi tiết sản phẩm
        $stock = $chitietsanpham->soluong; // Đây là số lượng sản phẩm trong kho

        // Kiểm tra nếu số lượng mới lớn hơn tồn kho
        if ($newQuantity <= $stock) {
            return response()->json(['success' => true, 'soluong' => $newQuantity]);
        } else {
            return response()->json(['success' => false, 'message' => 'Số lượng vượt quá tồn kho!']);
        }
    }

}
