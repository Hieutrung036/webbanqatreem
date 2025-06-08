<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiSanPham extends Model
{

    use HasFactory;
    protected $table = 'loaisanpham';
    protected $primaryKey = 'idlsp';
    public $timestamps = false;
    protected $fillable = ['ten', 'gioitinh',  'soluong'];
    public function sanpham()
    {
        return $this->hasMany(SanPham::class, 'idlsp', 'idlsp');
    }
    public function danhmucsanpham()
{
    return $this->belongsTo(DanhMucSanPham::class, 'iddm', 'iddm');
}
}
