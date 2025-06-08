<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMucSanPham extends Model
{
    use HasFactory;

    protected $table = 'danhmucsanpham';
    protected $primaryKey = 'iddm';
    public $timestamps = false;

    protected $fillable = ['ten','gioitinh', 'idlsp']; // Đảm bảo trường này khớp với cột trong DB

    public function loaisanpham()
    {
        return $this->hasMany(LoaiSanPham::class, 'iddm', 'iddm');
    }
}
