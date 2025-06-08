<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ChiTietSanPham;
use App\Models\HinhAnh;
use Illuminate\Http\Request;

class hinhanh1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hinhanhs = HinhAnh::all();
        return view('admin.hinhanh1', compact('hinhanhs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Kiểm tra xem đã có hình ảnh cho chi tiết sản phẩm này chưa
        $existingImage = HinhAnh::where('idctsp', $request->idctsp)->first();

        // Nếu đã có hình ảnh cho chi tiết sản phẩm này thì không cho thêm
        if ($existingImage) {
            return redirect()->back()->with('error', 'Hình ảnh đã tồn tại cho chi tiết sản phẩm này.');
        }

        // Kiểm tra nếu có file hình ảnh phụ
        if ($request->hasFile('hinhphu')) {
            $file = $request->file('hinhphu');
            $ext = $file->extension();
            $fileName = time() . '-' . 'hinhphu.' . $ext;
            $file->move(public_path('uploads/sanpham'), $fileName);
        }

        // Thêm dữ liệu vào bảng HinhAnh
        $hinhAnhData = [
            'duongdan' => $fileName,
            'idctsp' => $request->idctsp,
        ];
        HinhAnh::create($hinhAnhData);

        return redirect()->back()->with('success', 'Thêm thành công.');
    }





    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // Kiểm tra xem request có chứa file hình ảnh mới hay không
        if ($request->hasFile('hinhphu')) {
            $file = $request->file('hinhphu');
            $ext = $file->getClientOriginalExtension();

            // Tạo tên file mới với timestamp để tránh trùng lặp
            $fileName = time() . '-' . 'hinhphu.' . $ext;

            // Di chuyển file hình ảnh mới vào thư mục uploads
            $file->move(public_path('uploads/sanpham'), $fileName);

            // Cập nhật đường dẫn hình ảnh mới vào request
            $request->merge(['duongdan' => $fileName]);
            $request->merge(['idsp' => null]);
        }
        //dd($request->all());

        // Tìm hình ảnh cần cập nhật
        $hinhAnh = HinhAnh::findOrFail($id);
        $hinhcu = public_path('uploads/sanpham') . '/' . $hinhAnh->Duongdan;
        if (file_exists($hinhcu)) {
            @unlink($hinhcu);
        }
        // Cập nhật thông tin hình ảnh
        $hinhAnh->update($request->all());
        //dd(request()->all());
        // Chuyển hướng người dùng về trang danh sách hình ảnh với thông báo thành công
        return redirect()->back()->with('success', 'Cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hinhanh = HinhAnh::findOrFail($id);
        $hinhanh->delete();
        return redirect()->back()->with('success', 'Xóa thành công.');
    }
}
