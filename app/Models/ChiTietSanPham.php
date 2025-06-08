<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietSanPham extends Model
{
    use HasFactory;
    protected $table = 'chitietsanpham';
    protected $primaryKey = 'idctsp';
    public $timestamps = false;
    protected $fillable = ['soluong', 'idsp', 'idm', 'idkt'];

    public function hinhanh()
    {
        return $this->hasMany(HinhAnh::class, 'idctsp', 'idctsp');
    }
    public function kichthuoc()
    {
        return $this->belongsTo(KichThuoc::class, 'idkt', 'idkt');
    }
    public function mau()
    {
        return $this->belongsTo(Mau::class, 'idm', 'idm');
    }
    public function sanpham()
    {
        return $this->belongsTo(SanPham::class, 'idsp', 'idsp');
    }
    public function danhgia()
    {
        return $this->hasMany(DanhGia::class, 'idctsp', 'idctsp');
    }
    // public function chitietsanpham()
    // {
    //     return $this->hasMany(ChiTietSanPham::class, 'idsp', 'idsp');
    // }
    public function chitietdonhang()
    {
        return $this->belongsTo(ChiTietDonHang::class, 'idctsp', 'idctsp');
    }
    public function chitietgiohang()
    {
        return $this->belongsTo(ChiTietGioHang::class, 'idctsp', 'idctsp');
    }
    public function hinhanhs()
    {
        return $this->hasMany(HinhAnh::class, 'idm', 'idm');
    }
    
}
