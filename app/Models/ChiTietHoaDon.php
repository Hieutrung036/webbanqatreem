<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietHoaDon extends Model
{
    use HasFactory;
    protected $table = 'chitiethoadon';
    protected $primaryKey = 'idcthd';
    public $timestamps = false;
    protected $fillable = ['idctsp', 'idhd','soluong'];

    public function hoadon()
    {
        return $this->belongsTo(HoaDon::class, 'idhd', 'idhd');
    }
    public function chitietsanpham()
    {
        return $this->hasMany(ChiTietSanPham::class, 'idctsp', 'idctsp');
    }
    
}
