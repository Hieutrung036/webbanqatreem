<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ChiTietDonHang;
use App\Models\ChiTietSanPham;
use App\Models\MaGiamGia;
use App\Models\SanPham;
use Illuminate\Http\Request;

class themspdonhangController extends Controller
{
    public function show()
    {

        $sanpham = SanPham::paginate(10); // Phân trang lấy 10 sản phẩm


        return view('admin.themspdonhang', compact('sanpham'));
    }

    public function store(Request $request)
{
    // Lấy thông tin sản phẩm từ form
    $idctsp = $request->input('idctsp');
    $soluong = $request->input('soluong');
    
    // Lấy chi tiết sản phẩm từ cơ sở dữ liệu
    $chitietsanpham = ChiTietSanPham::find($idctsp);

    if ($chitietsanpham) {
        // Kiểm tra số lượng tồn kho
        if ($soluong > $chitietsanpham->soluong) {
            // Nếu số lượng yêu cầu lớn hơn số lượng tồn kho, trả lỗi
            return redirect()->back()->with('error', 'Số lượng vượt quá tồn kho.');
        }

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $cart = session()->get('cart', []);

        // Kiểm tra sản phẩm trong giỏ hàng
        $productExists = false;
        foreach ($cart as $key => $item) {
            if ($item['idctsp'] == $chitietsanpham->idctsp) {
                // Cập nhật số lượng nếu sản phẩm đã có trong giỏ
                $cart[$key]['soluong'] += $soluong;

                // Kiểm tra lại số lượng sau khi cập nhật
                if ($cart[$key]['soluong'] > $chitietsanpham->soluong) {
                    // Nếu số lượng vượt quá tồn kho, trả lỗi
                    return redirect()->back()->with('error', 'Số lượng vượt quá tồn kho.');
                }

                // Tính lại tổng tiền, nếu có mã giảm giá thì áp dụng giảm giá
                $gia = $chitietsanpham->sanpham->gia;

                // Kiểm tra xem sản phẩm có giảm giá không
                $giamgia = MaGiamGia::find($chitietsanpham->sanpham->idgg);
                if ($giamgia) {
                    $gia = $gia - ($gia * $giamgia->phantram / 100); // Áp dụng giảm giá
                }

                // Cập nhật tổng tiền sau khi tính giá mới
                $cart[$key]['total'] = $cart[$key]['soluong'] * $gia;
                $productExists = true;
                break;
            }
        }

        // Lấy hình ảnh sản phẩm (nếu có)
        $hinhphu = $chitietsanpham->hinhanh->first() ? $chitietsanpham->hinhanh->first()->duongdan : null;

        // Nếu sản phẩm chưa có trong giỏ, thêm mới
        if (!$productExists) {
            // Kiểm tra lại số lượng trước khi thêm vào giỏ hàng
            if ($soluong > $chitietsanpham->soluong) {
                // Nếu số lượng vượt quá tồn kho, trả lỗi
                return redirect()->back()->with('error', 'Số lượng vượt quá tồn kho.');
            }

            // Tính giá của sản phẩm, nếu có giảm giá thì áp dụng giảm giá
            $gia = $chitietsanpham->sanpham->gia;
            $giamgia = MaGiamGia::find($chitietsanpham->sanpham->idgg);
            if ($giamgia) {
                $gia = $gia - ($gia * $giamgia->phantram / 100); // Áp dụng giảm giá
            }

            // Thêm sản phẩm vào giỏ với giá đã được tính
            $cart[] = [
                'idctsp' => $chitietsanpham->idctsp,
                'ten' => $chitietsanpham->sanpham->ten,
                'soluong' => $soluong,
                'gia' => $gia,  // Lưu giá sau khi giảm
                'total' => $soluong * $gia,  // Tính tổng tiền
                'mau' => $chitietsanpham->mau->ten,
                'kichthuoc' => $chitietsanpham->kichthuoc->ten,
                'hinhphu' => $hinhphu,  // Lấy hình ảnh từ đúng chi tiết sản phẩm
            ];
        }

        // Lưu lại giỏ hàng vào session
        session()->put('cart', $cart);
    }

    return redirect()->route('admin.lapdonhang'); // Quay lại trang lập đơn hàng
}

    
    // Chỗ này có vấn đề 8h làm tiếp
}
