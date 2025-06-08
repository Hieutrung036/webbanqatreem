<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ChiTietDonHang;
use App\Models\ChiTietSanPham;
use App\Models\DonHang;
use App\Models\DonViVanChuyen;
use App\Models\MaGiamGia;
use App\Models\PhieuGiaoHang;
use App\Models\TrangThaiDonHang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class chitietdonhangController extends Controller
{
    public function index($iddh)
    {
        $donhang = DonHang::with('diachi')->where('iddh', $iddh)->first(); // Dùng first() để lấy 1 bản ghi

        $trangthaidonhang = TrangThaiDonHang::all();
        $giamgia = MaGiamGia::all();
        $chitietdonhang = ChiTietDonHang::where('iddh', $iddh)->paginate(10);
        $donvivanchuyen = DonViVanChuyen::all();
        $phieugiaohang = PhieuGiaoHang::all();


        // Lấy tất cả chi tiết sản phẩm của sản phẩm hiện tại
        return view('admin.chitietdonhang', compact('donhang', 'trangthaidonhang', 'giamgia', 'chitietdonhang', 'donvivanchuyen', 'phieugiaohang'));
    }



    public function xuathoadon($id)
    {
        // Lấy dữ liệu đơn hàng và chi tiết đơn hàng
        $donhang = DonHang::with('chitietdonhang.chitietsanpham.sanpham', 'chitietdonhang.chitietsanpham.hinhanh', 'diachi')
            ->findOrFail($id);

        // Render view hóa đơn và truyền dữ liệu
        $pdf = Pdf::loadView('admin.hoadon', compact('donhang'));

        // Xuất file PDF
        return $pdf->download('hoa-don-don-hang-' . $donhang->id . '.pdf');
    }


    public function lapphieugiaohanng(Request $request)
    {
        $validated = $request->validate([
            'iddh' => 'required|exists:donhang,iddh',
            'iddc' => 'required|exists:diachi,iddc',
            'iddvvc' => 'required|exists:donvivanchuyen,iddvvc',
            'ghichu' => 'nullable|string|max:255',
        ]);

        // Tạo phiếu giao hàng
        PhieuGiaoHang::create([
            'iddh' => $validated['iddh'],
            'iddc' => $validated['iddc'],
            'iddvvc' => $validated['iddvvc'],
            'ghichu' => $validated['ghichu'] ?? '',
        ]);

        // Lấy trạng thái "Đã bàn giao cho đơn vị vận chuyển"
        $trangthai = TrangThaiDonHang::where('ten', 'Đã bàn giao cho đơn vị vận chuyển')->first();

        if ($trangthai) {
            // Cập nhật trạng thái đơn hàng
            DonHang::where('iddh', $validated['iddh'])->update(['idttdh' => $trangthai->idttdh]);
        }
        
        $chitietdonhangs = ChiTietDonHang::where('iddh', $validated['iddh'])->get();

        foreach ($chitietdonhangs as $chitietdonhang) {
            // Giảm số lượng sản phẩm trong ChiTietSanPham
            $chitietsanpham = ChiTietSanPham::find($chitietdonhang->idctsp);
            if ($chitietsanpham) {
                // Giảm số lượng sản phẩm
                $chitietsanpham->soluong -= $chitietdonhang->soluong;
                $chitietsanpham->save();
            }
        }
        return redirect()->back()->with('success', 'Phiếu giao hàng đã được tạo thành công.');
    }
}







// Bỏ, không dùng nữa