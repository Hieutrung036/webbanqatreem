<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use App\Models\MaGiamGia;
use App\Models\KhachHang;
use App\Models\DiaChi;
use App\Models\HoaDon;
use App\Models\PhuongThucGiaoHang;
use App\Models\PhuongThucThanhToan;
use App\Models\TrangThaiDonHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class hoadonController extends Controller
{
    public function index()
    {
        $khachhang = KhachHang::all();
        $phuongthucthanhtoan = PhuongThucThanhToan::all(); // Lấy tất cả người dùng từ cơ sở dữ liệu
        $magiamgia = MaGiamGia::all(); // Lấy tất cả người dùng từ cơ sở dữ liệu
        $trangthaidonhang = TrangThaiDonHang::all(); // Lấy tất cả người dùng từ cơ sở dữ liệu

        $hoadon = HoaDon::with(['chitiethoadon', 'khachhang', 'phuongthucthanhtoan'])
            ->orderBy('idhd', 'desc')  // Sắp xếp theo ID đơn hàng từ mới nhất
            ->paginate(10); // Phân trang với 10 đơn hàng mỗi trang


        return view('admin.hoadon', compact('khachhang', 'hoadon', 'magiamgia', 'trangthaidonhang', 'phuongthucthanhtoan'));
    }

    public function destroy($idhd)
    {
        try {
            // Tìm đơn hàng theo ID
            $hoadon = HoaDon::findOrFail($idhd);

            // Lấy ID địa chỉ của đơn hàng
            $iddc = $hoadon->iddc;

            // Kiểm tra xem đơn hàng có phiếu giao hàng không
            $hasPhieuGiaoHang = $hoadon->phieugiaohang()->exists();

            // Nếu có phiếu giao hàng, xóa phiếu giao hàng
            if ($hasPhieuGiaoHang) {
                $hoadon->phieugiaohang()->delete();
            }

            // Kiểm tra xem đơn hàng có liên kết với người dùng không
            $hasUser = $hoadon->idkh != null;

            // Xóa chi tiết đơn hàng liên quan
            $hoadon->chitiethoadon()->delete();

            // Xóa đơn hàng
            $hoadon->delete();

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
            return redirect()->route('admin.hoadon')->with('success', 'Xóa thành công.');
        } catch (\Exception $e) {
            // Redirect với thông báo lỗi
            return redirect()->route('admin.hoadon')->with('error', 'Có lỗi xảy ra khi xóa đơn hàng.');
        }
    }



    public function updateOrderStatus($iddh)
    {
        // Tìm đơn hàng theo ID
        $hoadon = HoaDon::find($iddh);

        // Kiểm tra nếu đơn hàng tồn tại và trạng thái hiện tại là 'Chờ xác nhận'
        if ($hoadon && $hoadon->trangthaidonhang->ten == 'Chờ xác nhận') {
            // Tìm trạng thái 'Đã xác nhận'
            $trangthaidonhang = TrangThaiDonHang::where('ten', 'Đã xác nhận')->first();

            // Cập nhật trạng thái của đơn hàng
            if ($trangthaidonhang) {
                $hoadon->idttdh  = $trangthaidonhang->idttdh; // Gán idttdh mới
                $hoadon->save(); // Lưu thay đổi

                return redirect()->back()->with('success', 'Đơn hàng đã được xác nhận');
            }
        }

        return redirect()->back()->with('error', 'Không thể cập nhật trạng thái');
    }


    public function capnhatTrangThai($idhd)
    {
        $hoadon = HoaDon::findOrFail($idhd);

        if ($hoadon && $hoadon->trangthaidonhang->ten == 'Đã bàn giao cho đơn vị vận chuyển') {
            // Lấy ID của trạng thái "Đang vận chuyển"
            $trangthaidonhang = TrangThaiDonHang::where('ten', 'Đang vận chuyển')->first();

            // Cập nhật trạng thái của đơn hàng
            if ($trangthaidonhang) {
                $hoadon->idttdh  = $trangthaidonhang->idttdh; // Gán idttdh mới
                $hoadon->save(); // Lưu thay đổi

                return redirect()->back()->with('success', 'Đơn hàng đang vận chuyển');
            }

            return redirect()->back()->with('error', 'Không thể cập nhật trạng thái đơn hàng.');
        }

        return redirect()->back()->with('error', 'Đơn hàng không hợp lệ.');
    }
    public function capnhatTrangThai1($idhd)
    {
        $hoadon = HoaDon::findOrFail($idhd);

        if ($hoadon && $hoadon->trangthaidonhang->ten == 'Đang vận chuyển') {
            // Lấy ID của trạng thái "Đang vận chuyển"
            $trangthaidonhang = TrangThaiDonHang::where('ten', 'Giao hàng thành công')->first();

            // Cập nhật trạng thái của đơn hàng
            if ($trangthaidonhang) {
                $hoadon->idttdh  = $trangthaidonhang->idttdh; // Gán idttdh mới
                $hoadon->save(); // Lưu thay đổi

                return redirect()->back()->with('success', 'Giao hàng thành công');
            }

            return redirect()->back()->with('error', 'Không thể cập nhật trạng thái đơn hàng.');
        }

        return redirect()->back()->with('error', 'Đơn hàng không hợp lệ.');
    }
}
