<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GioHang extends Model
{
    use HasFactory;
    protected $table = 'giohang';
    protected $primaryKey = 'idgh';
    public $timestamps = false;
    protected $fillable = ['idpttt', 'idkh'];
    public function khachhang()
    {
        return $this->belongsTo(KhachHang::class, 'idkh', 'idkh');
    }
    public function phuongthucthanhtoan()
    {
        return $this->belongsTo(PhuongThucThanhToan::class, 'idpttt', 'idpttt');
    }
    public function chitietgiohang()
    {
        return $this->hasMany(ChiTietGioHang::class, 'idgh', 'idgh');
    }
}
