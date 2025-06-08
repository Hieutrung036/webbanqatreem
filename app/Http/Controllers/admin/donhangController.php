<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use App\Models\MaGiamGia;
use App\Models\KhachHang;
use App\Models\DiaChi;
use App\Models\PhuongThucGiaoHang;
use App\Models\PhuongThucThanhToan;
use App\Models\TrangThaiDonHang;
use Illuminate\Http\Request;

class donhangController extends Controller
{
    public function index()
    {
        $khachhang = KhachHang::all();
        $phuongthucthanhtoan = PhuongThucThanhToan::all(); // Lấy tất cả người dùng từ cơ sở dữ liệu
        $magiamgia = MaGiamGia::all(); // Lấy tất cả người dùng từ cơ sở dữ liệu
        $trangthaidonhang = TrangThaiDonHang::all(); // Lấy tất cả người dùng từ cơ sở dữ liệu

        $donhang = DonHang::with(['chitietdonhang', 'khachhang', 'phuongthucthanhtoan'])
            ->orderBy('iddh', 'desc')  // Sắp xếp theo ID đơn hàng từ mới nhất
            ->paginate(10); // Phân trang với 10 đơn hàng mỗi trang


        return view('admin.donhang', compact('khachhang', 'donhang', 'magiamgia', 'trangthaidonhang', 'phuongthucthanhtoan'));
    }

    public function destroy($id)
    {
        try {
            // Tìm đơn hàng theo ID
            $donhang = DonHang::findOrFail($id);

            // Lấy ID địa chỉ của đơn hàng
            $iddc = $donhang->iddc;

            // Kiểm tra xem đơn hàng có phiếu giao hàng không
            $hasPhieuGiaoHang = $donhang->phieugiaohang()->exists();

            // Nếu có phiếu giao hàng, xóa phiếu giao hàng
            if ($hasPhieuGiaoHang) {
                $donhang->phieugiaohang()->delete();
            }

            // Kiểm tra xem đơn hàng có liên kết với người dùng không
            $hasUser = $donhang->idnd != null;

            // Xóa chi tiết đơn hàng liên quan
            $donhang->chitietdonhang()->delete();

            // Xóa đơn hàng
            $donhang->delete();

            // Nếu đơn hàng có liên kết với người dùng, không xóa địa chỉ
            if (!$hasUser) {
                // Kiểm tra xem địa chỉ có còn được sử dụng không
                $isAddressUsedByUser = DiaChi::where('iddc', $iddc)->whereHas('khachhang')->exists();

                if (!$isAddressUsedByUser) {
                    // Nếu địa chỉ không còn được sử dụng, xóa địa chỉ
                    DiaChi::where('iddc', $iddc)->delete();
                }
            }

            // Redirect với thông báo thành công
            return redirect()->route('admin.donhang')->with('success', 'Xóa thành công.');
        } catch (\Exception $e) {
            // Redirect với thông báo lỗi
            return redirect()->route('admin.donhang')->with('error', 'Có lỗi xảy ra khi xóa đơn hàng.');
        }
    }



    public function updateOrderStatus($iddh)
    {
        // Tìm đơn hàng theo ID
        $donhang = DonHang::find($iddh);

        // Kiểm tra nếu đơn hàng tồn tại và trạng thái hiện tại là 'Chờ xác nhận'
        if ($donhang && $donhang->trangthaidonhang->ten == 'Chờ xác nhận') {
            // Tìm trạng thái 'Đã xác nhận'
            $trangthaidonhang = TrangThaiDonHang::where('ten', 'Đã xác nhận')->first();

            // Cập nhật trạng thái của đơn hàng
            if ($trangthaidonhang) {
                $donhang->idttdh  = $trangthaidonhang->idttdh; // Gán idttdh mới
                $donhang->save(); // Lưu thay đổi

                return redirect()->back()->with('success', 'Đơn hàng đã được xác nhận');
            }
        }

        return redirect()->back()->with('error', 'Không thể cập nhật trạng thái');
    }
}
