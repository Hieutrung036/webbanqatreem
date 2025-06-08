<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TinTuc;
use App\Models\LoaiTinTuc;
use App\Models\HinhAnh;
use Carbon\Carbon;
use Illuminate\Validation\Rule; // Đảm bảo import Rule ở đây

use Illuminate\Http\Request;

class tintucController extends Controller
{
    public function index()
    {

        $loaitintuc = LoaiTinTuc::all(); // Lấy tất cả người dùng từ cơ sở dữ liệu
        $tintuc = TinTuc::all();
        $tintuc = TinTuc::paginate(10); // Lấy 10 người dùng trên mỗi trang
        return view('admin.tintuc', compact('tintuc', 'loaitintuc'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'tieude' => 'required|string|max:100|unique:tintuc,tieude',
            'idltt' => 'required|exists:loaitintuc,idltt',
            'noidung' => 'required|string',
            'hinhchinh' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'tieude.required' => 'Trường tiêu đề là bắt buộc.',
            'idltt.required' => 'Vui lòng chọn loại tin tức.',
            'idltt.exists' => 'Loại tin tức không hợp lệ.',
            'tieude.unique' => 'Trùng tiêu đề.',
            'noidung.required' => 'Nội dung là bắt buộc.',
            'hinhchinh.required' => 'Hình ảnh chính là bắt buộc.',
            'hinhchinh.image' => 'Hình ảnh chính phải là định dạng hình ảnh.',
        ]);

        // Tạo tin tức mới
        $tintuc = new TinTuc();
        $tintuc->tieude = $request->input('tieude');
        $tintuc->noidung = nl2br($request->input('noidung')); // Sửa lại đây
        $tintuc->ngaydang = Carbon::now('Asia/Ho_Chi_Minh'); // Đảm bảo trường này tồn tại trong cơ sở dữ liệu
        $tintuc->noibat = $request->boolean('noibat'); // Lấy giá trị từ checkbox
        $tintuc->idltt = $request->input('idltt');

        if ($request->hasFile('hinhchinh')) {
            $file = $request->file('hinhchinh');
            $ext = $file->extension();
            $fileName = time() . '-' . 'tintuc.' . $ext;
            $file->move(public_path('uploads/tintuc'), $fileName); // Đường dẫn lưu
            $tintuc->hinhanh = $fileName; // Sửa lại cho đúng tên trường
        }

        $tintuc->save();
        return redirect()->back()->with('success', 'Tin tức đã được thêm thành công!');
    }


    public function destroy($idtt)
    {
        // Tìm bản ghi tin tức
        $tintuc = TinTuc::find($idtt);

        if ($tintuc) {
            // Kiểm tra và xóa hình ảnh nếu có
            if ($tintuc->hinhanh) {
                $imagePath = public_path('uploads/tintuc/' . $tintuc->hinhanh);
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Xóa file hình ảnh
                }
            }
            // Xóa bản ghi trong bảng `TinTuc`
            $tintuc->delete();

            return redirect()->back()->with('success', 'Tin tức đã được xóa thành công!');
        }
    }



    public function update(Request $request, $idtt)
    {
        // Xác thực dữ liệu
        $request->validate([
            'tieude' => [
                'required',
                'string',
                'max:100',
                Rule::unique('tintuc')->ignore($idtt, 'idtt'),
            ],
            'idltt' => 'required|exists:loaitintuc,idltt',
            'noidung' => 'required|string',
            'hinhchinh' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'tieude.required' => 'Trường tiêu đề là bắt buộc.',
            'idltt.required' => 'Vui lòng chọn loại tin tức.',
            'idltt.exists' => 'Loại tin tức không hợp lệ.',
            'tieude.unique' => 'Trùng tiêu đề.',
            'noidung.required' => 'Nội dung là bắt buộc.',
            'hinhchinh.image' => 'Hình ảnh chính phải là định dạng hình ảnh.',
        ]);

        // Tìm bản ghi tin tức
        $tintuc = TinTuc::findOrFail($idtt);

        // Cập nhật thông tin
        $tintuc->tieude = $request->input('tieude');
        $tintuc->noidung =  nl2br($request->input('noidung'));
        $tintuc->noibat = $request->boolean('noibat'); // Lấy giá trị từ checkbox
        $tintuc->idltt = $request->input('idltt');
        $tintuc->ngaydang = Carbon::now('Asia/Ho_Chi_Minh'); // Đảm bảo trường này tồn tại trong cơ sở dữ liệu

        // Kiểm tra và xử lý hình ảnh nếu có hình mới
        if ($request->hasFile('hinhchinh')) {
            // Xóa hình ảnh cũ nếu có
            if ($tintuc->hinhanh) {
                $oldImagePath = public_path('uploads/tintuc/' . $tintuc->hinhanh);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Lưu hình ảnh mới với tên cố định
            $file = $request->file('hinhchinh');
            $ext = $file->extension();
            $fileName = time() . '-tintuc.' . $ext;
            $file->move(public_path('uploads/tintuc'), $fileName);

            // Cập nhật tên file hình ảnh mới
            $tintuc->hinhanh = $fileName;
        }

        // Lưu thay đổi vào cơ sở dữ liệu
        $tintuc->save();

        return redirect()->back()->with('success', 'Thông tin tin tức đã được cập nhật thành công.');
    }



    public function search(Request $request)
    {
        $query = $request->input('query'); // Lấy từ khóa tìm kiếm từ yêu cầu

        // Tìm kiếm người dùng theo tên hoặc email
        $tintuc = TinTuc::where('tieude', 'LIKE', "%{$query}%")
            ->paginate(10); // Phân trang kết quả tìm kiếm

        return view('admin.tintuc', compact('tintuc')); // Trả về view với danh sách người dùng tìm được
    }

   
    
}
