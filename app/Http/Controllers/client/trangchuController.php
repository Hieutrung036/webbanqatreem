<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\ChiTietGioHang;
use App\Models\ChiTietSanPham;
use App\Models\DanhMucSanPham;
use App\Models\GioHang;
use App\Models\HinhAnh;
use App\Models\KichThuoc;
use Illuminate\Http\Request;
use App\Models\LoaiSanPham;
use App\Models\LoaiTinTuc;
use App\Models\Mau;
use App\Models\SanPham;
use App\Models\TinTuc;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class trangchuController extends Controller
{
    //
    public function index()
    {
        // Lấy các loại sản phẩm, sản phẩm mới, sản phẩm nổi bật, loại tin tức và tin tức
        $danhmucsanpham = DanhMucSanPham::all();
        $sanphamMoi = Sanpham::where('moi', 1)->orderBy('idsp', 'desc')->take(10)->get();
        $sanphamNoiBat = Sanpham::where('noibat', 1)->orderBy('idsp', 'desc')->take(10)->get();

        // Lấy chi tiết sản phẩm và eager load các quan hệ mau, kichthuoc

        $loaitintuc = LoaiTinTuc::all();
        $tintuc = TinTuc::where('noibat', 1)->orderBy('idtt', 'desc')->take(10)->get();

        // Lấy chi tiết giỏ hàng
        if (auth()->check()) {
            $idkh = auth()->user()->idkh;

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
            return view('client.trangchu', compact(
                'danhmucsanpham',
                'loaitintuc',
                'sanphamMoi',
                'sanphamNoiBat',
                'tintuc',
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
                if (isset($item['sanpham']) && $item['sanpham'] instanceof \App\Models\ChiTietSanPham
                ) {
                    $sanpham = $item['sanpham'];

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
            return view('client.trangchu', compact('danhmucsanpham', 'loaitintuc', 'chitietgiohang', 'tongTien', 'soLuongSanPham', 'sanphamMoi', 'sanphamNoiBat', 'tintuc',));
        }
    }

    public function xemnhanh($id)
    {
        $sanpham = SanPham::with(['thuonghieu', 'loaisanpham', 'chitietsanpham.mau', 'chitietsanpham.kichthuoc'])
            ->find($id);

        if (!$sanpham) {
            return response()->json(['error' => 'Sản phẩm không tồn tại!'], 404);
        }

        $hinhanh = HinhAnh::where('idsp', $id)->first();

        // Tính giá sau giảm giá (nếu có)
        $price = $sanpham->gia;
        $originalPrice = $sanpham->gia;
        if ($sanpham->giamgia && $sanpham->giamgia->phantram > 0) {
            $price = $sanpham->gia - ($sanpham->gia * $sanpham->giamgia->phantram) / 100;
        }

        // Lấy chi tiết màu sắc và kích thước
        $colorSizeData = [];
        foreach ($sanpham->chitietsanpham as $ctsp) {
            $colorSizeData[$ctsp->mau->ten][] = [
                'size' => $ctsp->kichthuoc->ten,
                'description' => $ctsp->kichthuoc->mota
            ];
        }

        $imageUrl = asset('uploads/sanpham/' . $hinhanh->duongdan);

        return response()->json([
            'name' => $sanpham->ten,
            'price' => $price, // Giá giảm
            'originalPrice' => $originalPrice, // Giá gốc
            'brand' => $sanpham->thuonghieu->ten,
            'code' => $sanpham->idsp,
            'category' => $sanpham->loaisanpham->ten,
            'image' => $sanpham->image_url,
            'colorSizeData' => $colorSizeData,
            'slug' => Str::slug($sanpham->ten),
            'id' => $sanpham->idsp,
            'image' => $imageUrl,
        ]);
    }



    public function addToCart(Request $request)
    {
        // Kiểm tra thông tin đầu vào
        $validated = $request->validate([
            'productId' => 'required|integer',
            'color' => 'required|string',
            'size' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        // Kiểm tra nếu validation thất bại
        if ($errors = $request->errors()) {
            return response()->json(['message' => 'Dữ liệu không hợp lệ', 'errors' => $errors]);
        }

        // Kiểm tra trạng thái đăng nhập
        if (auth()->check()) {
            // Người dùng đã đăng nhập -> Thêm vào bảng `giohang` và `chitietgiohang`
            $cart = GioHang::firstOrCreate(['idkh' => auth()->id()]);

            // Thêm sản phẩm vào chi tiết giỏ hàng
            ChiTietGioHang::create([
                'idgh' => $cart->idgh,
                'idctsp' => $validated['productId'],
                'soluong' => $validated['quantity'],
            ]);

            return response()->json(['message' => 'Sản phẩm đã được thêm vào giỏ hàng.']);
        } else {
            // Người dùng chưa đăng nhập -> Lưu vào session
            $cart = session()->get('cart', []);
            $cart[] = [
                'idctsp' => $validated['productId'],
                'color' => $validated['color'],
                'size' => $validated['size'],
                'quantity' => $validated['quantity'],
            ];
            session()->put('cart', $cart);

            return response()->json(['message' => 'Sản phẩm đã được lưu vào giỏ hàng tạm thời (session).']);
        }
    }



}
