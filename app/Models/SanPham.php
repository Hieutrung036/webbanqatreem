<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{

    use HasFactory;

    protected $table = 'sanpham';
    protected $primaryKey = 'idsp';

    // Xác định các trường có thể điền
    protected $fillable = ['ten', 'mota', 'soluong', 'gia', 'chatlieu', 'moi', 'noibat','idgg','idth','idlsp']; 
    public $timestamps = false;

    // Nếu muốn, bạn có thể thêm quan hệ với bảng NguoiDung
    
    public function giamgia()
    {
        return $this->belongsTo(MaGiamGia::class, 'idgg', 'idgg');
    }
    public function thuonghieu()
    {
        return $this->belongsTo(ThuongHieu::class, 'idth', 'idth');
    }
    public function loaisanpham()
    {
        return $this->belongsTo(LoaiSanPham::class, 'idlsp', 'idlsp');
    }
    public function chitietsanpham()
    {
        return $this->hasMany(ChiTietSanPham::class, 'idsp', 'idsp');
    }

    public function hinhanh()
    {
        return $this->hasMany(HinhAnh::class, 'idsp', 'idsp');
    }
}
