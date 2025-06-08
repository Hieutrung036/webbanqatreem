<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chat'; // Tên bảng
    protected $primaryKey = 'idc'; // Khóa chính
    public $timestamps = false; // Tắt timestamps nếu không sử dụng cột `created_at` và `updated_at`

    protected $fillable = [
        'noidung',
        'thoigian',
        'idkh',
        'idnv',
        'loai_nguoi_gui',  // Thêm cột loai_nguoi_gui
        'da_xem',           // Thêm cột da_xem
    ];

    // Quan hệ với khách hàng
    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'idkh', 'idkh');
    }

    // Quan hệ với nhân viên
    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'idnv', 'idnv');
    }

    // Lấy người gửi tin nhắn (khách hàng hoặc nhân viên)
    public function nguoiGui()
    {
        return $this->loai_nguoi_gui == 'khachhang' ? $this->khachHang() : $this->nhanVien();
    }
}
