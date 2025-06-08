<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\HoaDon;
use Illuminate\Http\Request;

class hoantienController extends Controller
{
    public function store(Request $request, $id)
    {
        // Kiểm tra tồn tại hóa đơn
        $hoadon = HoaDon::find($id);
        if (!$hoadon) {
            return response()->json(['error' => 'Đơn hàng không tồn tại'], 404);
        }

        // Xử lý yêu cầu hoàn tiền (cập nhật trạng thái, lưu lý do, v.v.)
        // Ví dụ: Cập nhật trạng thái đơn hàng thành 'Yêu cầu hoàn tiền'
        $hoadon->trang_thai = 'Yêu cầu hoàn tiền';
        $hoadon->ly_do_hoan_tien = $request->lydo;  // Cập nhật lý do hoàn tiền
        $hoadon->save();

        return response()->json(['message' => 'Yêu cầu hoàn tiền thành công']);
    }
}
