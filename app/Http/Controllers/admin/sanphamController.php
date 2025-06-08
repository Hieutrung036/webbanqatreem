<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\LoaiSanPham;
use App\Models\MaGiamGia;
use App\Models\SanPham;
use App\Models\ThuongHieu;
use App\Models\ChiTietSanPham;
use App\Models\HinhAnh;
use Illuminate\Http\Request;

class sanphamController extends Controller
{
    public function index()
    {
        $chitietsanpham = ChiTietSanPham::all();
        $magiamgia = MaGiamGia::all(); // Lấy tất cả người dùng từ cơ sở dữ liệu
        $thuonghieu = ThuongHieu::all(); // Lấy tất cả người dùng từ cơ sở dữ liệu
        $loaisanpham = LoaiSanPham::all(); // Lấy tất cả người dùng từ cơ sở dữ liệu

        $sanpham = SanPham::all();
        $sanpham = SanPham::paginate(10); // Lấy 10 người dùng trên mỗi trang
        return view('admin.sanpham', compact('sanpham', 'magiamgia', 'thuonghieu', 'loaisanpham'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten' => 'required|string|max:100',
            'mota' => 'required|string',
            'gia' => 'required|numeric|min:0',
            'chatlieu' => 'required|string|max:100',
            'moi' => 'boolean',
            'noibat' => 'boolean',
            'idgg' => 'required|exists:giamgia,idgg',
            'idth' => 'required|exists:thuonghieu,idth',
            'idlsp' => 'required|exists:loaisanpham,idlsp',
        ]);

        // Tạo người dùng mới
        $sanpham = new SanPham();
        $sanpham->ten = $request->input('ten');
        $sanpham->mota = $request->input('mota');
        $sanpham->gia = $request->input('gia');
        $sanpham->chatlieu = $request->input('chatlieu');
        $sanpham->moi = $request->boolean('moi'); // Lấy giá trị từ checkbox
        $sanpham->noibat = $request->boolean('noibat'); // Lấy giá trị từ checkbox
        $sanpham->idgg = $request->input('idgg');
        $sanpham->idth = $request->input('idth');
        $sanpham->idlsp = $request->input('idlsp');

        // Lưu người dùng vào database
        $sanpham->save();

        // Quay lại trang trước hoặc về trang danh sách người dùng với thông báo thành công
        return redirect()->back()->with('success', 'Sản phẩm đã được thêm thành công!');
    }

    public function destroy($id)
    {
        $sanpham = SanPham::findOrFail($id);
        $chitiet = $sanpham->chitietsanpham;
        if ($chitiet) {
            foreach ($chitiet as $chitietsanpham) {

                $hinhanh = HinhAnh::where('idctsp', $chitietsanpham->idctsp)->get();
                if ($hinhanh) {
                    foreach ($hinhanh as $hinhanhs) {
                        $hinhanhs->delete();
                    }
                }

                $chitietsanpham->delete();
            }
        }
        $hinhanhchinh = HinhAnh::where('idsp', $id)->get();
        if ($hinhanhchinh) {
            foreach ($hinhanhchinh as $hinhanhs) {
                $hinhanhs->delete();
            }
        }
        $sanpham->delete();
        return redirect('admin/sanpham')->with('success', 'Xóa thành công.');
    }





    public function update(Request $request, $idsp)
    {
        // Xác thực dữ liệu
        $request->validate([
            'ten' => 'required|string|max:100',
            'mota' => 'required|string',
            'gia' => 'required|numeric|min:0',
            'chatlieu' => 'required|string|max:100',
            'moi' => 'boolean',
            'noibat' => 'boolean',
            'idgg' => 'required|exists:giamgia,idgg',
            'idth' => 'required|exists:thuonghieu,idth',
            'idlsp' => 'required|exists:loaisanpham,idlsp',
        ]);
        // Tìm loại sản phẩm
        $sanpham = SanPham::findOrFail($idsp);

        // Cập nhật thông tin
        $sanpham->ten = $request->input('ten');
        $sanpham->mota = $request->input('mota');
        $sanpham->gia = $request->input('gia');
        $sanpham->chatlieu = $request->input('chatlieu');
        $sanpham->moi = $request->boolean('moi'); // Lấy giá trị từ checkbox
        $sanpham->noibat = $request->boolean('noibat'); // Lấy giá trị từ checkbox
        $sanpham->idgg = $request->input('idgg');
        $sanpham->idth = $request->input('idth');
        $sanpham->idlsp = $request->input('idlsp');


        // Lưu thay đổi vào cơ sở dữ liệu
        $sanpham->save();

        return redirect()->back()->with('success', 'Thông tin sản phẩm đã được cập nhật thành công.');
    }
    public function search(Request $request)
    {
        $query = $request->input('query'); // Lấy từ khóa tìm kiếm từ yêu cầu
        $magiamgia = MaGiamGia::all(); // Lấy tất cả người dùng từ cơ sở dữ liệu
        $thuonghieu = ThuongHieu::all(); // Lấy tất cả người dùng từ cơ sở dữ liệu
        $loaisanpham = LoaiSanPham::all(); // Lấy tất cả người dùng từ cơ sở dữ liệu
        // Tìm kiếm người dùng theo tên hoặc email
        $sanpham = SanPham::where('ten', 'LIKE', "%{$query}%")
            ->orWhere('soluong', 'LIKE', "%{$query}%")
            ->orWhere('gia', 'LIKE', "%{$query}%")
            ->orWhere('chatlieu', 'LIKE', "%{$query}%")
            ->paginate(10); // Phân trang kết quả tìm kiếm

        return view('admin.sanpham', compact('sanpham', 'magiamgia', 'thuonghieu', 'loaisanpham')); // Trả về view với danh sách người dùng tìm được
    }
}
