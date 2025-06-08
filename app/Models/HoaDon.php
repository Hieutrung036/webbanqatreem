<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoaDon extends Model
{
    use HasFactory;
    protected $table = 'hoadon';
    protected $primaryKey = 'idhd';
    public $timestamps = false;
    protected $fillable = [ 'tongtien', 'ngaydathang', 'ngaynhanhang', 'idgg', 'idpttt', 'idttdh', 'idkh', 'iddc', 'idptgh', 'ngaylap', 'idnv'];

    public function nhanvien()
    {
        return $this->belongsTo(NhanVien::class, 'idnv', 'idnv');
    }
    public function phieugiaohang()
    {
        return $this->belongsTo(PhieuGiaoHang::class, 'idhd', 'idhd');
    }
    public function phuongthucthanhtoan()
    {
        return $this->belongsTo(PhuongThucThanhToan::class, 'idpttt', 'idpttt');
    }
    public function trangthaidonhang()
    {
        return $this->belongsTo(TrangThaiDonHang::class, 'idttdh', 'idttdh');
    }
    public function chitiethoadon()
    {
        return $this->hasMany(ChiTietHoaDon::class, 'idhd', 'idhd');
    }
    public function giamgia()
    {
        return $this->hasMany(MaGiamGia::class, 'idgg', 'idgg');
    }
    public function khachhang()
    {
        return $this->belongsTo(KhachHang::class, 'idkh', 'idkh');
    }

    public function diachi()
    {
        return $this->belongsTo(DiaChi::class, 'iddc', 'iddc');
    }
    public function phuongthucgiaohang()
    {
        return $this->belongsTo(PhuongThucGiaoHang::class, 'idptgh', 'idptgh');
    }
}
