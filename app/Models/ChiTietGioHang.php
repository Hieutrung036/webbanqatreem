<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietGioHang extends Model
{
    use HasFactory;
    protected $table = 'chitietgiohang';
    protected $primaryKey = 'idctgh';
    public $timestamps = false;
    protected $fillable = ['idctsp', 'idgh','soluong'];

    public static function countChiTietGioHang($idgh)
    {
        return self::where('idgh', $idgh)->sum('soluong');
    }
    public function giohang()
    {
        return $this->hasMany(GioHang::class, 'idgh', 'idgh');
    }
    public function chitietsanpham()
    {
        return $this->hasMany(ChiTietSanPham::class, 'idctsp', 'idctsp');
    }
}
