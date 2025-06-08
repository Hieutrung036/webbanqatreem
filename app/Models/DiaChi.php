<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiaChi extends Model
{
    use HasFactory;

    protected $table = 'diachi';
    protected $primaryKey = 'iddc';

    // Xác định các trường có thể điền
    protected $fillable = ['tennguoinhan', 'sdt', 'diachi', 'phuongxa', 'quanhuyen', 'tinhthanhpho', 'idkh']; // Thêm 'idnd' vào đây
    public $timestamps = false;

    // Nếu muốn, bạn có thể thêm quan hệ với bảng NguoiDung
    public function khachhang()
    {
        return $this->belongsTo(KhachHang::class, 'idkh', 'idkh');
    }
}
