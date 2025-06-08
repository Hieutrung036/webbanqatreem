<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    use HasFactory;
    protected $table = 'donhang';
    protected $primaryKey = 'iddh';
    public $timestamps = false;
    protected $fillable = ['soluong', 'tongtien','ngaydathang','ngaynhanhang','idgg', 'idpttt','idttdh','idkh','iddc','idptgh'];

    public function thongtinthanhtoan()
    {
        return $this->hasMany(ThongTinThanhToan::class, 'iddh', 'iddh');
    }
    public function phieugiaohang()
    {
        return $this->belongsTo(PhieuGiaoHang::class, 'iddh', 'iddh');
    }
    public function phuongthucthanhtoan()
    {
        return $this->belongsTo(PhuongThucThanhToan::class, 'idpttt', 'idpttt');
    }
    public function trangthaidonhang()
    {
        return $this->belongsTo(TrangThaiDonHang::class, 'idttdh', 'idttdh');
    }
    public function chitietdonhang()
    {
        return $this->hasMany(ChiTietDonHang::class, 'iddh', 'iddh');
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
