<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ChiTietSanPham;
use App\Models\KichThuoc;
use App\Models\Mau;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class chitietsanpham1Controller extends Controller
{
    public function index($id)
    {
        $sanpham = SanPham::findOrFail($id);

        $chitietsanpham = ChiTietSanPham::paginate(5);

        $mau = Mau::all();
        $kichthuoc = KichThuoc::all();
        return view('admin.chitietsanpham1', compact('sanpham', 'mau', 'kichthuoc', 'chitietsanpham'));
    }
    public function store(Request $request)
{
    // Kiểm tra và validate dữ liệu gửi lên
    $request->validate([
        'idsp' => 'required|integer|exists:sanpham,idsp',
        'idm' => 'required|integer|exists:mau,idm',
        'idkt' => [
            'required',
            'integer',
            'exists:kichthuoc,idkt',
            // Kiểm tra unique với điều kiện
            Rule::unique('chitietsanpham')->where(function ($query) use ($request) {
                return $query->where('idsp', $request->idsp)
                    ->where('idm', $request->idm);
            }),
        ],
        'soluong' => 'required|integer|min:0',  // Kiểm tra số lượng không âm
    ], [
        'idkt.unique' => 'Trùng kích thước.',
        'soluong.min' => 'Số lượng không thể âm.',
    ]);

    // Tạo mới chi tiết sản phẩm
    $chitietsanpham = new ChiTietSanPham($request->only(['idsp', 'idm', 'idkt', 'soluong']));

    // Lưu chi tiết sản phẩm vào cơ sở dữ liệu
    $chitietsanpham->save();

    // Tìm và gán màu cho sản phẩm
    $mau = Mau::find($request->idm);
    $chitietsanpham->mau()->associate($mau);

    // Tìm và gán kích thước cho sản phẩm
    $kichThuoc = KichThuoc::find($request->idkt);
    $chitietsanpham->kichthuoc()->associate($kichThuoc);

    // Trả về thông báo thành công
    return redirect()->back()->with('success', 'Thêm thành công.');
}

    public function destroy($id)
    {
        $chitietsanpham = ChiTietSanPham::findOrFail($id);


        $chitietsanpham->delete();
        return redirect()->back()->with('success', 'Xóa thành công.');
    }

    public function update(Request $request, $id)
    {
        // Kiểm tra và validate dữ liệu gửi lên từ form
        $request->validate([
            'idsp' => 'required|integer|exists:sanpham,idsp',
            'idm' => 'required|integer|exists:mau,idm',
            'idkt' => [
                'required',
                'integer',
                'exists:kichthuoc,idkt',
                // Kiểm tra tính duy nhất của kết hợp các trường
                Rule::unique('chitietsanpham')->where(function ($query) use ($request, $id) {
                    return $query->where('idsp', $request->idsp)
                        ->where('idm', $request->idm)
                        ->where('idkt', $request->idkt)
                        ->where('idctsp', '<>', $id); // Loại bỏ bản ghi có ID hiện tại
                }),
            ],
            'soluong' => 'required|int|min:0',  // Đảm bảo số lượng không âm
        ], [
            'idkt.unique' => 'Trùng kích thước.',
            'soluong.min' => 'Số lượng không thể âm.',
        ]);
    
        // Tìm chi tiết sản phẩm cần cập nhật
        $chitietsanpham = ChiTietSanPham::findOrFail($id);
    
        // Cập nhật chi tiết sản phẩm với dữ liệu mới
        $chitietsanpham->update([
            'idsp' => $request->idsp,
            'idm' => $request->idm,
            'idkt' => $request->idkt,
            'soluong' => $request->soluong,  // Cập nhật số lượng
        ]);
    
        return redirect()->back()->with('success', 'Cập nhật thành công.');
    }
    

    
}
