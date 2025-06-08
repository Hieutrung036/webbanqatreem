<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\ChiTietGioHang;
use App\Models\DanhMucSanPham;
use App\Models\LoaiTinTuc;
use App\Models\SanPham;
use App\Models\TinTuc;
use Illuminate\Http\Request;

class timkiemController extends Controller
{
    public function timKiem(Request $request)
    {
        $danhmucsanpham = DanhMucSanPham::all();
        $sanphamMoi = Sanpham::where('moi', 1)->orderBy('idsp', 'desc')->take(10)->get();
        $sanphamNoiBat = Sanpham::where('noibat', 1)->orderBy('idsp', 'desc')->take(10)->get();
        $loaitintuc = LoaiTinTuc::all();
        $tintuc = TinTuc::where('noibat', 1)->orderBy('idtt', 'desc')->take(10)->get();
        $chitietgiohang = ChiTietGioHang::with('chitietsanpham.sanpham')->get();
    
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
    
        $keyword = $request->input('keyword');
    
        // Tìm kiếm sản phẩm theo tên hoặc mô tả và phân trang
        $sanpham = SanPham::where('ten', 'LIKE', "%$keyword%")
            ->orWhere('mota', 'LIKE', "%$keyword%")
            ->paginate(12);  // Số lượng sản phẩm mỗi trang là 12
    
        // Trả kết quả ra view
        return view('client.timkiem', compact('sanpham', 'keyword', 'danhmucsanpham', 'loaitintuc', 'sanphamMoi', 'sanphamNoiBat', 'tintuc', 'chitietgiohang', 'tongTien', 'soLuongSanPham'));
    }
    

    
}
