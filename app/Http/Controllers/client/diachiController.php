<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\DiaChi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class diachiController extends Controller
{

    public function store(Request $request, $id)
    {
        $request->validate([
            'tennguoinhan' => 'required|string|max:255',
            'sdt' => 'required|string|max:255',
            'diachi' => 'required|string|max:255',
            'phuongxa' => 'required|string|max:255',
            'quanhuyen' => 'required|string|max:255',
            'tinhthanhpho' => 'required|string|max:255',
        ]);
        $diachi = new DiaChi();
        $diachi->tennguoinhan = $request->tennguoinhan;
        $diachi->sdt = $request->sdt;
        $diachi->diachi = $request->diachi;
        $diachi->phuongxa = $request->phuongxa;
        $diachi->quanhuyen = $request->quanhuyen;
        $diachi->tinhthanhpho = $request->tinhthanhpho;
        $diachi->idkh = $id;

        $diachi->save();

        return redirect::back()->with('success', 'Địa chỉ đã được thêm thành công.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'tennguoinhan' => 'required|string|max:255',
            'sdt' => 'required|digits_between:10,15',  // Hoặc dùng 'regex:/^[0-9]{10,15}$/'
            'diachi' => 'required|string|max:255',
            'phuongxa' => 'required|string|max:255',
            'quanhuyen' => 'required|string|max:255',
            'tinhthanhpho' => 'required|string|max:255',
        ]);

        $diachi = DiaChi::findOrFail($id);
        $diachi->update($request->only([
            'tennguoinhan',
            'sdt',
            'diachi',
            'phuongxa',
            'quanhuyen',
            'tinhthanhpho'
        ]));

        return Redirect::back()->with('success', 'Sửa địa chỉ thành công.');
    }




    public function destroy($id)
    {
        $diachi = DiaChi::findOrFail($id);
        $diachi->delete();

        return redirect::back()->with('success', 'Xóa địa chỉ thành công.');
    }
}
