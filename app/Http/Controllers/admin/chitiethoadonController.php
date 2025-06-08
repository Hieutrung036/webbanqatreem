<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ChiTietDonHang;
use App\Models\ChiTietHoaDon;
use App\Models\ChiTietSanPham;
use App\Models\DonHang;
use App\Models\DonViVanChuyen;
use App\Models\HoaDon;
use App\Models\MaGiamGia;
use App\Models\PhieuGiaoHang;
use App\Models\TrangThaiDonHang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class chitiethoadonController extends Controller
{
    public function index($idhd)
    {
        $hoadon = HoaDon::with('diachi')->where('idhd', $idhd)->first(); // Dùng first() để lấy 1 bản ghi

        $trangthaidonhang = TrangThaiDonHang::all();
        $giamgia = MaGiamGia::all();
        $chitiethoadon = ChiTietHoaDon::where('idhd', $idhd)->paginate(10);
        $donvivanchuyen = DonViVanChuyen::all();
        $phieugiaohang = PhieuGiaoHang::all();


        // Lấy tất cả chi tiết sản phẩm của sản phẩm hiện tại
        return view('admin.chitiethoadon', compact('hoadon', 'trangthaidonhang', 'giamgia', 'chitiethoadon', 'donvivanchuyen', 'phieugiaohang'));
    }
   


    public function xuathoadon($id)
    {
        // Lấy dữ liệu đơn hàng và chi tiết đơn hàng
        $hoadon = HoaDon::with('chitiethoadon.chitietsanpham.sanpham', 'chitiethoadon.chitietsanpham.hinhanh', 'diachi')
            ->findOrFail($id);

        // Render view hóa đơn và truyền dữ liệu
        $pdf = Pdf::loadView('admin.inhoadon', compact('hoadon'));

        // Xuất file PDF
        return $pdf->download('hoa-don-don-hang-' . $hoadon->id . '.pdf');
    }


    public function lapphieugiaohanng(Request $request)
    {
        // Validate dữ liệu gửi lên từ form
        $validated = $request->validate([
            'idhd' => 'required|exists:hoadon,idhd',
            'iddc' => 'required|exists:diachi,iddc',
            'iddvvc' => 'required|exists:donvivanchuyen,iddvvc',
            'ghichu' => 'nullable|string|max:255',
        ]);
    
        // Tạo phiếu giao hàng
        PhieuGiaoHang::create([
            'idhd' => $validated['idhd'],
            'iddc' => $validated['iddc'],
            'iddvvc' => $validated['iddvvc'],
            'ghichu' => $validated['ghichu'] ?? '', // Nếu không có ghi chú thì mặc định là chuỗi rỗng
        ]);
    
        // Lấy trạng thái "Đã bàn giao cho đơn vị vận chuyển"
        $trangthai = TrangThaiDonHang::where('ten', 'Đã bàn giao cho đơn vị vận chuyển')->first();
    
        if ($trangthai) {
            // Cập nhật trạng thái đơn hàng
            HoaDon::where('idhd', $validated['idhd'])->update(['idttdh' => $trangthai->idttdh]);
        }
        
        // Giảm số lượng sản phẩm trong ChiTietSanPham
        $chitiethoadons = ChiTietHoaDon::where('idhd', $validated['idhd'])->get();
    
        foreach ($chitiethoadons as $chitiethoadon) {
            $chitietsanpham = ChiTietSanPham::find($chitiethoadon->idctsp);
            if ($chitietsanpham) {
                $chitietsanpham->soluong -= $chitiethoadon->soluong;
                $chitietsanpham->save();
            }
        }
    
        return redirect()->back()->with('success', 'Phiếu giao hàng đã được tạo thành công.');
    }
    
}
