<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ChiTietSanPham;
use App\Models\SanPham;
use App\Models\HinhAnh;
use App\Models\KichThuoc;
use App\Models\LoaiSanPham;
use App\Models\Mau;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class chitietsanphamController extends Controller
{

    public function show(Request $request, $id)
    {
        $sanpham = SanPham::findOrFail($id); // Tìm sản phẩm dựa theo ID
        // Lấy tất cả chi tiết sản phẩm của sản phẩm hiện tại
        $chitietsanpham = ChiTietSanPham::where('idsp', $sanpham->idsp)->get(); // Sửa ở đây nếu `idsp` là khóa ngoại trong `ChiTietSanPham`
        $mau = Mau::all();
        $kichthuoc = KichThuoc::all();
        $hinhanh = $sanpham->hinhanh; // Nếu bạn đã định nghĩa quan hệ 'hinhanh' trong mô hình SanPham
        return view('admin.chitietsanpham', compact('sanpham', 'mau', 'kichthuoc', 'chitietsanpham', 'hinhanh'));
    }




    public function store(Request $request)
    {
        $request->validate([
            'idsp' => 'required|integer|exists:SanPham,IDSP',
            'idm' => 'required|integer|exists:Mau,IDM',
            'idkt' => [
                'required',
                'integer',
                'exists:KichThuoc,IDKT',
                // Kiểm tra unique với điều kiện
                Rule::unique('chitietsanpham')->where(function ($query) use ($request) {
                    return $query->where('idsp', $request->idsp)
                        ->where('idm', $request->idm);
                }),
            ],
            'soluong' => 'required|int',
        ], [
            'idkt.unique' => 'Trùng kích thước.',
        ]);
        $chitietsanpham = new ChiTietSanPham($request->only(['idsp', 'idm', 'idkt', 'soluong']));
        $chitietsanpham->save();
        $mau = Mau::find($request->idm);
        $chitietsanpham->mau()->associate($mau);
        $kichThuoc = KichThuoc::find($request->idkt);
        $chitietsanpham->kichthuoc()->associate($kichThuoc);
        return redirect()->back()->with('success', 'Thêm màu và kích thước thành công.');
    }
}
